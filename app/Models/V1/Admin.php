<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory,
    Illuminate\Database\Eloquent\Model,
    Illuminate\Support\Facades\Hash,
    Illuminate\Support\Str,
    Illuminate\Support\Arr,
    App\Support\Facades\V1\Models\AdminRoleInfoFacade;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'string',
        'phone' => 'int',
        'status' => 'int',
        'authority' => 'int'
    ];

    protected $hidden = [
        'password',
        'hash',
        'access_token'
    ];

    protected $fillable = [
        'id',
        'name',
        'nick_name',
        'hash',
        'password',
        'phone',
        'email',
        'status',
        'access_token',
        'authority'
    ];

    /**
     * 查询校验参数
     *
     * @var array
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-14 13:31:51
     */
    public function findWhere()
    {
        return ['id', 'name', 'nick_name', 'phone', 'email', 'status', 'access_token'];
    }

    /**
     * 管理员详情
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-19 11:30:02
     * @return void
     */
    public function infoId()
    {
        return $this->hasOne('App\Models\V1\AdminInfo', 'id', 'id');
    }

        
    public function adminRole(){
        return $this->hasMany('App\Models\V1\AdminRole','admin_id','id');
    }

    public function roles(){
        return $this->belongsToMany('App\Models\V1\AdminRoleInfo', 'admin_role', 'admin_id', 'role_id');
    }


    /**
     *
     *管理员列表
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-14 19:52:33
     * @param array $params
     * @return void
     */
    public function search($page, $limit, $params = [])
    {
        $page = ceil($page - 1) / $limit;
        $model = $this->where(function ($model) use ($params) {
            if (count($params) > 0) {
                foreach ($params as $k => $v) {
                    switch ($k) {
                        case 'id':
                            $model->where($k, $v);
                            break;
                        case 'status':
                            $model->where($k, $v);
                            break;
                        default:
                            $model->where($k, 'like', $v . '%');
                            break;
                    }
                }
            }
        })->with('infoId')->with('roles');
        $count = $model->count();
        $result = $model->offset($page)->limit($limit)->get()->toArray();
        foreach ($result as $k => $v) {
            $info = $v['info_id'];
            $role=[];
            $authority=[];
            //角色id
            $admin_role_ids= count($v['roles'])>0?Arr::pluck($v['roles'], 'pivot.role_id'):[];
           if (count($admin_role_ids)>0) {
                $authoritys=AdminRoleInfoFacade::roleAuthoritys(array_unique($admin_role_ids));
                foreach($authoritys as $m=>$n){
                    $role[$n->id]=[
                        'id'=>$n->id,
                        'name'=>$n->name,
                        'status'=>[
                            'key'=>$n->status,
                            'value'=>$n->status? trans('admin.status_off') : trans('admin.status_on')
                        ]
                    ];
                    foreach($n->authoritys as $h=>$i){
                        $authority[$i->id]=[
                            'id'=>$i->id,
                            'parent_id'=>$i->parent_id,
                            'code'=>$i->code,
                            'name'=>$i->name,
                            'show'=>[
                                'key'=>$i->show,
                                'value'=>$i->show? trans('admin.show_off') : trans('admin.show_on')
                            ],
                            'status'=>[
                                'key'=>$i->status,
                                'value'=>$i->status? trans('admin.status_off') : trans('admin.status_on')
                            ],
                        ];
                    }
        
                }
           }
            $result[$k] = [
                'id' => $v['id'],
                'name' => $v['name'],
                'role'=>Arr::shuffle($role),
                'authority'=>Arr::shuffle($authority),
                'nick_name' => $v['nick_name'],
                'phone' => $v['phone'],
                'email' => $v['email'],
                'status' => [
                    'key' => $v['status'],
                    'value' => $v['status'] ? trans('admin.status_off') : trans('admin.status_on')
                ],
                'real_name' => $info['real_name'],
                'sex' => [
                    'key' => $info['sex'],
                    'value' => $info['sex'] ? trans('admin.admin_sex_man') : trans('admin.admin_sex_woman'),
                ],
                'age' => $info['age'] == 0 ? date("Y") - $info['year'] : $info['age'],
                'birth' => $info['year'] . '-' . $info['month'] . '-' . $info['day'],
                'img' => $info['img'],
                'create_time' => $info['create_time'],
                'update_time' => $info['update_time']
            ];
            unset($v['info_id']);
        }

        return [
            'list' => $result,
            'count' => $count
        ];
    }
    public function store($data)
    {
        return $this->create($data);
    }
    /**
     * 更新管理员
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-22 17:56:51
     * @param array $data
     * @param [type] $id
     * @return void
     */
    public function updateData($data, $id)
    {
        return $this->where('id', $id)->update($data);
    }

    public function deleteAll($id)
    {
        return $this->whereIn('id', $id)->delete();
    }
    /**
     * 密码加密
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-19 16:21:07
     * @param [type] $password
     * @return void
     */
    public function setPassword($password)
    {
        return Hash::make($password);
    }

    /**
     * 校验密码
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-20 10:45:53
     * @param [type] $password
     * @param [type] $hash
     * @return void
     */
    public function checkPassword($password, $hash)
    {
        if (Hash::check($password, $hash)) {
            return true;
        }
        return false;
    }

    /**
     * 获取用户密码及hash
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-16
     * @param [type] $username
     * @return void
     */
    public function getPassword(string $username)
    {
        if (preg_match('/^[1][3456789][0-9]{9}$/', $username)) {
            $result = $this->where('phone', $username)->with('roles')->first();
        } elseif (preg_match('/^[a-z0-9A-Z]+[- | a-z0-9A-Z . _]+@([a-z0-9A-Z]+(-[a-z0-9A-Z]+)?\\.)+[a-z]{2,}$/', $username)) {
            $result = $this->where('email', $username)->with('roles')->first();
        } else {
            $result = $this->where('name', $username)->with('roles')->first();
        }
        $role_ids=[];
        foreach($result->roles as $k=>$v){
            if($v->status==0){
                $role_ids[]=$v->id;
            }
        }
        $authority=[];
        if (count($role_ids)>0) {
            $authoritys=AdminRoleInfoFacade::roleAuthoritys(array_unique($role_ids));
            foreach ($authoritys as $f=>$g) {
                foreach($g->authoritys as $m=>$n){
                    if($n->show==1){
                        continue;
                    }
                    if($n->status==1){
                        continue;
                    }
                    $authority[]=[
                        'id'=>$n->id,
                        'parent_id'=>$n->parent_id,
                        'code'=>$n->code,
                        'name'=>$n->name
                    ];
                }
            }
        }
        $result->authority_status=[
            'key'=> $result->authority,
            'value'=> $result->authority? trans('admin.authority_sort') : trans('admin.authority_hight')
        ];
        $result->authority_info=$result->authority==0?[]:$authority;
        return $result;
    }

    /**
     * 生成token校验hash
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-16
     * @param [type] $salt
     * @return void
     */
    public function setToken($id)
    {
        $token = Str::random(88);
        $result = $this->updateData(['access_token' => $token, 'token_hash' => Hash::make($token)], $id);
        if (false == $result) {
            return false;
        }
        return $token;
    }

    /**
     * 获取tokenhash
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-17
     * @param [type] $token
     * @return void
     */
    public function getTokenHash($token)
    {
        return $this->select('token_hash', 'id')->where('access_token', $token)->first();
    }

    /**
     * 校验token
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-17
     * @param [type] $token
     * @param [type] $token_hash
     * @return void
     */
    public function checkToken($token, $token_hash)
    {
        if (Hash::check($token, $token_hash)) {
            return true;
        }
        return false;
    }

    public function getFirstData($id)
    {
        return $this->where('id', $id)->first();
    }
}

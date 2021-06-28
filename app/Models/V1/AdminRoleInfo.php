<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model,
    App\Support\Facades\V1\Models\AdminAuthorityFacade;

class AdminRoleInfo extends Model
{
    protected $table = 'admin_role_info';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'string',
        'status' => 'int'
    ];

    protected $hidden = [];

    protected $fillable = [
        'id',
        'status',
        'name',
        'create_time'
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
        return ['id', 'name', 'status', 'create_time'];
    }


    public function authoritys(){
        return $this->belongsToMany('App\Models\V1\AdminAuthority', 'admin_role_authority', 'role_id', 'authority_id');
    }

    /**
     * 获取角色权限
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-28
     * @param array $id
     * @return void
     */
    public function roleAuthoritys($id){
        return $this->whereIn('id',$id)->with('authoritys')->get();
    }

    public function search($page, $limit, $params = [])
    {
        $page = ceil($page - 1) / $limit;
        $model = $this->where(function ($model) use ($params) {
            if (count($params) > 0) {
                foreach ($params as $k => $v) {
                    switch ($k) {
                        case 'id':
                            $model->where($k, $v);
                        case 'create_time':
                            $model->where($k, '>=', $v[0]);
                            $model->where($k, '<=', $v[1]);
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
        })->with('authoritys');
        $count = $model->count();
        $result = $model->offset($page)->limit($limit)->get()->toArray();
        foreach ($result as $m => $n) {
            $authority = [];
            if (count($n['authoritys']) > 0) {
                foreach ($n['authoritys'] as $k => $v) {
                    $authority[] =[
                        'id'=>$v['id'],
                        'parent_id'=>$v['parent_id'],
                        'code'=>$v['code'],
                        'name'=>$v['name'],
                        'show'=>[
                            'key'=>$v['show'],
                            'value'=>$v['show']? trans('admin.show_off') : trans('admin.show_on')
                        ],
                        'status'=>[
                            'key'=>$v['status'],
                            'value'=>$v['status']? trans('admin.status_off') : trans('admin.status_on')
                        ],
                    ];
                }
            }
            $result[$m] = [
                'id' => $n['id'],
                'name' => $n['name'],
                'authority' => $authority,
                'status' => [
                    'key' => $n['status'],
                    'value' => $n['status'] ? trans('admin.status_off') : trans('admin.status_on')
                ],
                'create_time' => $n['create_time']
            ];
        }
        return [
            'list' => $result,
            'count' => $count
        ];
    }
    /**
     * 新增角色
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param [type] $data
     * @return void
     */
    public function store($data)
    {
        return $this->create($data);
    }

    /**
     * 批量更新
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param [type] $data
     * @param [type] $id
     * @return void
     */
    public function updateData($data, $id)
    {
        return $this->where('id', $id)->update($data);
    }

    /**
     * 批量删除
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param [type] $id
     * @return void
     */
    public function deleteAll($id)
    {
        return $this->whereIn('id', $id)->delete();
    }
}

<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory,
    App\Common\HelperCommon,
    Illuminate\Database\Eloquent\Model,
    Illuminate\Support\Facades\Log;

class AdminAuthority extends Model
{
    use HasFactory;
    protected $table = 'admin_authority';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'string',
        'parent_id' => 'string',
        'show' => 'int',
        'status' => 'int'
    ];

    protected $hidden = [];

    protected $fillable = [
        'id',
        'parent_id',
        'code',
        'name',
        'show',
        'status'
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
        return ['id', 'parent_id', 'name', 'show', 'status', 'code'];
    }

    /**
     * 获取父级权限数据
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @return void
     */
    public function getParent()
    {
        return $this->select('id', 'parent_id', 'name')->get()->toArray();
    }

    /**
     * 获取不显示且未禁止的权限
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @return void
     */
    public function getLoginAuthority()
    {
        $result = $this->where(['show' => 0, 'status' => 0])->get();
        $parent =  HelperCommon::array_keys_header($this->getParent(), 'id');
        foreach ($result as $m => $n) {
            $result[$m] = [
                'id' => $n['id'],
                'parent_id' => $n['parent_id'],
                'parent_name' => $n['parent_id'] == 0 ? trans('admin.authority_top') : $parent[$n['parent_id']]['name'],
                'code' => $n['code'],
                'name' => $n['name']
            ];
        }
        return $result;
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
                        case 'parent_id':
                            $model->where($k, $v);
                            break;
                        case 'status':
                            $model->where($k, $v);
                            break;
                        case 'show':
                            $model->where($k, $v);
                            break;
                        default:
                            $model->where($k, 'like', $v . '%');
                            break;
                    }
                }
            }
        });
        $count = $model->count();
        $result = $model->offset($page)->limit($limit)->get()->toArray();
        $parent =  HelperCommon::array_keys_header($this->getParent(), 'id');
        foreach ($result as $m => $n) {
            $result[$m] = [
                'id' => $n['id'],
                'parent_id' => $n['parent_id'],
                'parent_name' => $n['parent_id'] == 0 ? trans('admin.authority_top') : $parent[$n['parent_id']]['name'],
                'code' => $n['code'],
                'name' => $n['name'],
                'show' => [
                    'key' => $n['show'],
                    'value' => $n['show'] ? trans('admin.show_off') : trans('admin.show_on')
                ],
                'status' => [
                    'key' => $n['status'],
                    'value' => $n['status'] ? trans('admin.status_off') : trans('admin.status_on')
                ]
            ];
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
     * 更新
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param array $data
     * @param [type] $id
     * @return void
     */
    public function updateData($data, $id)
    {
        return $this->where('id', $id)->update($data);
    }

    /**
     * 删除
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
        return $this->whereIn('id', $id)->destroy();
    }
}

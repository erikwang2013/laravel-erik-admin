<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model,
    App\Common\HelperCommon;

class AdminAuthority extends Model
{
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
        'name'
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
        return ['id', 'parent_id', 'name', 'show', 'status'];
    }

    public function getParent()
    {
        return $this->select('id', 'parent_id', 'name')->get()->toArray();
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

    public function updateData($data, $id)
    {
        return $this->where('id', $id)->update($data);
    }

    public function deleteAll($id)
    {
        return $this->whereIn('id', $id)->destroy();
    }
}

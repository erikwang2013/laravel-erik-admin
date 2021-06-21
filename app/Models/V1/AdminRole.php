<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'admin_id' => 'string',
        'role_id' => 'string'
    ];

    protected $hidden = [];

    protected $fillable = [
        'admin_id',
        'role_id'
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
        return ['admin_id', 'role_id'];
    }

    /**
     * 批量新增
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param [type] $data
     * @return void
     */
    public function storeAll($data)
    {
        return $this->insert($data);
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
        return $this->whereIn('admin_id', $id)->delete();
    }

    /**
     * 单个删除
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param [type] $id
     * @return void
     */
    public function deleteOne($id)
    {
        return $this->where('admin_id', $id)->delete();
    }
}

<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

class AdminRoleAuthority extends Model
{
    protected $table = 'admin_role_authority';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'authority_id' => 'string',
        'role_id' => 'string'
    ];

    protected $hidden = [];

    protected $fillable = [
        'authority_id',
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
        return ['authority_id', 'role_id'];
    }

    /**
     * 新增
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
}

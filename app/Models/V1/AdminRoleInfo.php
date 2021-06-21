<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

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
}

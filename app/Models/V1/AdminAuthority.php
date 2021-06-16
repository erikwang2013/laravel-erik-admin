<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

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
        return ['id', 'parent_id', 'code', 'name', 'show', 'status'];
    }
}

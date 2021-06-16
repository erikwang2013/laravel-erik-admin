<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    protected $table = 'admin_info';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'string',
        'sex' => 'int',
        'age' => 'int',
        'year' => 'int',
        'month' => 'int',
        'day' => 'int',
    ];

    protected $hidden = [];

    protected $fillable = [
        'id',
        'real_name',
        'img',
        'create_time',
        'update_time',
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
        return ['id', 'real_name', 'sex', 'age', 'year', 'month', 'day', 'img', 'create_time', 'update_time'];
    }

    /**
     * 新增管理员详情
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-19 15:26:20
     * @param [type] $data
     * @return void
     */
    public function create($data)
    {
        $result = $this->create($data);
        return $result;
    }

    /**
     * 更新管理员详情
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-22 17:59:16
     * @param [type] $data
     * @param [type] $id
     * @return void
     */
    public function updateData($data, $id)
    {
        return $this->where('id', $id)->update($data);
    }

    public function deleteAll($id)
    {
        return $this->whereIn('id', $id)->destroy();
    }
}

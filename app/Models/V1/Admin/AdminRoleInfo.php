<?php
namespace App\Models\V1\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminRoleInfo extends Model
{
    protected $table = 'admin_role_info';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id'=>'string',
        'status'=>'int'
	];

	protected $hidden = [];

	protected $fillable = [
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
	public function findWhere(){
		return ['id','name','status','create_time'];
	}

}
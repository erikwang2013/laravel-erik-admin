<?php
namespace App\Models\V1\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'admin_id'=>'string',
		'role_id'=>'string'
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
	public function findWhere(){
		return ['admin_id','role_id'];
	}

}
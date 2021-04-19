<?php
namespace App\Models\V1\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminRoleAuthority extends Model
{
    protected $table = 'admin_role_authority';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'authority_id'=>'string',
		'role_id'=>'string'
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
	public $findWhere=['authority_id','role_id'];
}
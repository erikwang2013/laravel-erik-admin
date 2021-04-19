<?php
namespace App\Models\V1\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    protected $table = 'admin_info';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id'=>'string',
		'phone'=>'int',
		'status' => 'int'
	];

	protected $hidden = [
		'password',
        'hash',
		'access_token'
	];

	protected $fillable = [
		'id',
		'real_name',
		'sex',
        'age',
        'year',
        'month',
        'day',
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
	public $findWhere=['id','name','nick_name','phone','email','status','access_token'];
}
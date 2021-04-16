<?php

namespace App\Models\V1\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
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
		'name',
		'nick_name',
		'hash',
		'password',
		'phone',
		'email',
		'status',
		'access_token'
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

	/**
	 * 
	 *管理员列表
	 * @Author erik
	 * @Email erik@erik.xyz
	 * @Url https://erik.xyz
	 * @DateTime 2021-04-14 19:52:33
	 * @param array $params
	 * @return void
	 */
	public function search($params=[],$page,$limit){	
		$page=ceil($page-1)/$limit;
		$model=Model::where(function($model) use($params){
			if(count($params)>0){
				foreach($params as $k=>$v){
					switch($k){
						case 'id':
							$model->where($k,(int)$v);
							break;
						case 'status':
							$model->where($k,$v);
							break;
						default:
						$model->where($k,'like',$v.'%');
						break;
					}
				}
			}
		});
		$count=$model->count();
		$result=$model->offset($page)->limit($limit)->get()->toArray();
		foreach($result as $k=>$v){
			$result[$k]['status']=[
				'key'=>$v['status'],
				'value'=>$v['status']?trans('admin.status_off'):trans('admin.status_on')
			];
		}

		return [
			'list'=>$result,
			'count'=>$count
		];
	}
}

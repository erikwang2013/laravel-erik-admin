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
	 * 管理员详情
	 *
	 * @Author erik
	 * @Email erik@erik.xyz
	 * @Url https://erik.xyz
	 * @DateTime 2021-04-19 11:30:02
	 * @return void
	 */
	public function infoId(){
		return $this->hasOne('App\Models\V1\Admin\AdminInfo','id','id');
	}


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
		})->with('infoId');
		$count=$model->count();
		$result=$model->offset($page)->limit($limit)->get()->toArray();
		foreach($result as $k=>$v){
			$info=$v['info_id'];
			$result[$k]=[
				'id'=>$v['id'],
				'name'=>$v['name'],
				'nick_name'=>$v['nick_name'],
				'phone'=>$v['phone'],
				'email'=>$v['email'],
				'status'=>[
					'key'=>$v['status'],
					'value'=>$v['status']?trans('admin.status_off'):trans('admin.status_on')
				],
				'real_name'=>$info['real_name'],
				'sex'=>[
					'key'=>$info['sex'],
					'value'=>$info['sex']?trans('admin.admin_sex_man'):trans('admin.admin_sex_woman'),
				],
				'age'=>$info['age']==0?date("Y")-$info['year']:$info['age'],
				'birth'=>$info['year'].'-'.$info['month'].'-'.$info['day'],
				'img'=>$info['img'],
				'create_time'=>$info['create_time'],
				'update_time'=>$info['update_time']
			];
			unset($v['info_id']);
		}

		return [
			'list'=>$result,
			'count'=>$count
		];
	}


	public function create($data){
		$result=Model::create($data);
		return $result;
	}
}

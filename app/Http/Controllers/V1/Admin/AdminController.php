<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller,
    Illuminate\Http\Request,
    App\Models\V1\Admin\Admin,
    App\Models\V1\Admin\AdminInfo,
    App\Common\HelperCommon,
    App\Validate\V1\PageValidator,
    App\Http\Validations\V1\BaseValidation,
    Illuminate\Support\Facades\DB,
    Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params=$request->input();
        //校验数据
        $validator=new BaseValidation();
        if(!$validator->validateRequest($request, 'index')){
            return HelperCommon::reset([],0,1,$validator->getError());
        }
        //验证分页
        $pageData=[
            'page'=>isset($params['page'])?$params['page']:config('app.page'),
            'limit'=>isset($params['limit'])?$params['limit']:config('app.limit')
        ];
        if(!$validator->check($pageData)){
            return HelperCommon::reset([],0,1,$validator->getError());
        }
        $model=new Admin();
        //过滤存在的数据
        $data=HelperCommon::filterKey($model,$params,0);   
        $result=$model->search($data,$pageData['page'],$pageData['limit']);
        return HelperCommon::reset($result['list'],$result['count']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        $params=$request->input();
        //校验数据
        $validator=new BaseValidation();
        if(!$validator->validateRequest($request, 'store')){
            return HelperCommon::reset([],0,1,$validator->getError());
        }

        //生成唯一id
        $id=HelperCommon::getCreateId();
        $model=new Admin();
        $params['id']=$id;
        
        //过滤存在的数据
        $data=HelperCommon::filterKey($model,$params,0); 
        $data['hash']=$model->setPassword($params['password']);
        $data['password']=$params['password'];
        DB::beginTransaction();
        $result=$model->create($data);
        if(!$result){
            DB::rollBack();
            return HelperCommon::reset([],0,1,trans('admin.create_data_fail'));
        }
        $admin=new AdminInfo();
        $info_data=HelperCommon::filterKey($admin,$params,0); 
        $info_result=$admin->create($info_data);
        if(!$info_result){
            DB::rollBack();
            return HelperCommon::reset([],0,1,trans('admin.create_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([],0,0);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params=$request->input();
        $params['id']=$id;
        //校验数据
        $validator=new BaseValidation();
        if(!$validator->validateRequest($request, 'update')){
            return HelperCommon::reset([],0,1,$validator->getError());
        }
        unset($params['id']);
        $model=new Admin();
        DB::beginTransaction();
        $result=$model->updateData($params,$id);
        if(!$result){
            DB::rollBack();
            return HelperCommon::reset([],0,1,trans('admin.create_data_fail'));
        }
        $admin=new AdminInfo();
        $info_data=HelperCommon::filterKey($admin,$params,0); 
        $info_result=$admin->updateData($info_data,$id);
        if(!$info_result){
            DB::rollBack();
            return HelperCommon::reset([],0,1,trans('admin.create_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([],0,0);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids=explode(',',$id);
        $validator=new BaseValidation();
        foreach($ids as $k=>$v){
            $validator = Validator::make(['id'=>$v], ['id'=>'numeric|min:19|required']);
            if ($validator->fails()) {
                return HelperCommon::reset([],0,1,$validator->errors());
            }
        }
        $model=new Admin();
        DB::beginTransaction();
        $result=$model->deleteAll($ids);
        if(!$result){
            DB::rollBack();
            return HelperCommon::reset([],0,1,trans('admin.delete_data_fail'));
        }
        $admin=new AdminInfo();
        $info_result=$admin->deleteAll($ids);
        if(!$info_result){
            DB::rollBack();
            return HelperCommon::reset([],0,1,trans('admin.delete_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([],0,0);
    }
}

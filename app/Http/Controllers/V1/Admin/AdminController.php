<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller,
    Illuminate\Http\Request,
    App\Models\V1\Admin\Admin,
    App\Common\HelperCommon,
    App\Validate\V1\PageValidator,
    App\Http\Validations\V1\BaseValidation;


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
        $model=new Admin();
        //过滤存在的数据
        $data=HelperCommon::filterKey($model,$params,0);   
        
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
        //生成唯一id
        $params=$request->input();
        $id=HelperCommon::getCreateId();
        $model=new Admin();
        $params['id']=$id;
        //过滤存在的数据
        $data=HelperCommon::filterKey($model,$params,0); 
        $result=$model->create($data);
        if(!$result){
            return HelperCommon::reset([],0,1,trans('admin.create_data_fail'));
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

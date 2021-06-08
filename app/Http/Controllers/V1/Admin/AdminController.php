<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller,
    Illuminate\Http\Request,
    App\Support\Facades\V1\Models\AdminFacade,
    App\Support\Facades\V1\Models\AdminInfoFacade,
    App\Common\HelperCommon,
    App\Support\Facades\V1\Models\BaseValidationFacade,
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
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'index')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        //验证分页
        $pageData = [
            'page' => isset($params['page']) ? $params['page'] : config('app.page'),
            'limit' => isset($params['limit']) ? $params['limit'] : config('app.limit')
        ];
        if (!BaseValidationFacade::check($pageData)) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminFacade::class, $params, 0);
        $result = AdminFacade::search($data, $pageData['page'], $pageData['limit']);
        return HelperCommon::reset($result['list'], $result['count']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'store')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }

        //生成唯一id
        $id = HelperCommon::getCreateId();
        $params['id'] = $id;

        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminFacade::class, $params, 0);
        $data['hash'] = AdminFacade::setPassword($params['password']);
        $data['password'] = $params['password'];
        DB::beginTransaction();
        $result = AdminFacade::create($data);
        if (!$result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('admin.create_data_fail'));
        }
        $info_data = HelperCommon::filterKey(AdminInfoFacade::class, $params, 0);
        $info_result = AdminInfoFacade::create($info_data);
        if (!$info_result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('admin.create_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([], 0, 0);
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
        $params = $request->input();
        $params['id'] = $id;
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'update')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        unset($params['id']);
        DB::beginTransaction();
        $result = AdminFacade::updateData($params, $id);
        if (!$result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('admin.create_data_fail'));
        }
        $info_data = HelperCommon::filterKey(AdminInfoFacade::class, $params, 0);
        $info_result = AdminInfoFacade::updateData($info_data, $id);
        if (!$info_result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('admin.create_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([], 0, 0);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = explode(',', $id);
        foreach ($ids as $k => $v) {
            $validator = Validator::make(['id' => $v], ['id' => 'numeric|min:19|required']);
            if ($validator->fails()) {
                return HelperCommon::reset([], 0, 1, $validator->errors());
            }
        }
        DB::beginTransaction();
        $result = AdminFacade::deleteAll($ids);
        if (!$result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('admin.delete_data_fail'));
        }
        $info_result = AdminInfoFacade::deleteAll($ids);
        if (!$info_result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('admin.delete_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([], 0, 0);
    }
}

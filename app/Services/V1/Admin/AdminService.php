<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminFacade,
    App\Support\Facades\V1\Models\AdminInfoFacade,
    App\Common\HelperCommon,
    Illuminate\Support\Facades\DB;

class AdminService
{
    /**
     * 管理员列表
     *
     * @param [type] $data
     * @param [type] $pageData
     * @return void
     */
    public function index($data, $pageData)
    {
        $result = AdminFacade::search($pageData['page'], $pageData['limit'], $data);
        return HelperCommon::reset($result['list'], $result['count']);
    }

    /**
     * 新增管理员
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-08
     * @param [type] $data
     * @param [type] $params
     * @return void
     */
    public function store($data, $params)
    {
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
     * 更新管理员
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-08
     * @param [type] $params
     * @param [type] $id
     * @return void
     */
    public function update($params, $id)
    {

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
     * 删除管理员
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-08
     * @param [type] $ids
     * @return void
     */
    public function destroy($ids)
    {
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

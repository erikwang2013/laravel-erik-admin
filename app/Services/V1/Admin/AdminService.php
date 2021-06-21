<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminFacade,
    App\Support\Facades\V1\Models\AdminInfoFacade,
    App\Common\HelperCommon,
    Illuminate\Support\Facades\DB,
    Exception;

class AdminService
{
    /**
     * 管理员列表
     *
     * @param [type] $data
     * @param [type] $pageData
     * @return void
     */
    public function index($params, $pageData)
    {
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminFacade::class, $params, 0);
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
    public function store($params)
    {
        $admin_data = HelperCommon::filterKey(AdminFacade::class, $params, 0);
        $info_data = HelperCommon::filterKey(AdminInfoFacade::class, $params, 0);
        $data['hash'] = AdminFacade::setPassword($params['password']);
        $data['password'] = $params['password'];
        try {
            DB::beginTransaction();
            if (count($admin_data) == 0) {
                $result = AdminFacade::store($data);
                if (!$result) {
                    DB::rollBack();
                    return HelperCommon::reset([], 0, 1, trans('public.create_data_fail'));
                }
            }
            if (count($info_data) == 0) {
                if ($info_data['year']) {
                    $info_data['age'] = (date('Y') - $info_data['year']) + 1;
                }
                $info_result = AdminInfoFacade::store($info_data);
                if (!$info_result) {
                    DB::rollBack();
                    return HelperCommon::reset([], 0, 1, trans('public.create_data_fail'));
                }
            }
            DB::commit();
            return HelperCommon::reset([], 0, 0);
        } catch (Exception $e) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, $e->getMessage());
        }
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
        $admin_data = HelperCommon::filterKey(AdminFacade::class, $params, 0);
        $info_data = HelperCommon::filterKey(AdminInfoFacade::class, $params, 0);
        try {
            DB::beginTransaction();
            if (count($admin_data) > 0) {
                $result = AdminFacade::updateData($admin_data, $id);
                if (!$result) {
                    DB::rollBack();
                    return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
                }
            }

            if (count($info_data) > 0) {
                if ($info_data['year']) {
                    $info_data['age'] = (date('Y') - $info_data['year']) + 1;
                }
                $info_result = AdminInfoFacade::updateData($info_data, $id);
                if (!$info_result) {
                    DB::rollBack();
                    return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
                }
            }
            DB::commit();
            return HelperCommon::reset([], 0, 0);
        } catch (Exception $e) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, $e->getMessage());
        }
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
            return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
        }
        $info_result = AdminInfoFacade::deleteAll($ids);
        if (!$info_result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([], 0, 0);
    }
}

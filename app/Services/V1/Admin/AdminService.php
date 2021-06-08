<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminFacade,
    App\Support\Facades\V1\Models\AdminInfoFacade,
    App\Common\HelperCommon,
    App\Support\Facades\V1\Models\BaseValidationFacade,
    Illuminate\Support\Facades\DB;

class AdminService
{
    public function index($data, $pageData)
    {
        $result = AdminFacade::search($data, $pageData['page'], $pageData['limit']);
        return HelperCommon::reset($result['list'], $result['count']);
    }

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

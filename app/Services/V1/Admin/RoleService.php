<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminRoleAuthorityFacade,
    App\Support\Facades\V1\Models\AdminRoleFacade,
    App\Support\Facades\V1\Models\AdminRoleInfoFacade,
    App\Common\HelperCommon;

class RoleService
{
    public function index($params, $page)
    {
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminRoleInfoFacade::class, $params, 0);
        $result = AdminRoleInfoFacade::search($page['page'], $page['limit'], $data);
        return HelperCommon::reset($result['list'], $result['count']);
    }

    public function store($params)
    {
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminRoleInfoFacade::class, $params, 0);
        $result = AdminRoleInfoFacade::store($data);
        if (!$result) {
            return  HelperCommon::reset([], 0, 1, trans('public.create_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }

    public function update($params, $id)
    {
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminRoleInfoFacade::class, $params, 0);
        $result = AdminRoleInfoFacade::updateData($data, $id);
        if (!$result) {
            return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }

    public function destroy($id)
    {
        $result = AdminRoleInfoFacade::deleteAll($id);
        if (!$result) {
            return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }
}

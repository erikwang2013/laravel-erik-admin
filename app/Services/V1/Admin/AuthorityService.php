<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminAuthorityFacade,
    App\Common\HelperCommon;

class AuthorityService
{
    public function index($params, $page)
    {
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminAuthorityFacade::class, $params, 0);
        $result = AdminAuthorityFacade::search($page['page'], $page['limit'], $data);
        return HelperCommon::reset($result['list'], $result['count']);
    }

    public function store($params)
    {
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminAuthorityFacade::class, $params, 0);
        $result = AdminAuthorityFacade::store($data);
        if (!$result) {
            return  HelperCommon::reset([], 0, 1, trans('public.create_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }

    public function update($params, $id)
    {
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminAuthorityFacade::class, $params, 0);
        $result = AdminAuthorityFacade::updateData($data, $id);
        if (!$result) {
            return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }

    public function destroy($id)
    {
        $result = AdminAuthorityFacade::deleteAll($id);
        if (!$result) {
            return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }
}

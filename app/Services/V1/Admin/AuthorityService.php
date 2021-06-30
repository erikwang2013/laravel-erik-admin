<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminAuthorityFacade,
    App\Common\HelperCommon;

class AuthorityService
{
    public function index($params, $page)
    {
        $token = $params['token'];
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminAuthorityFacade::class, $params, 0);
        $result = AdminAuthorityFacade::search($page['page'], $page['limit'], $data);
        return HelperCommon::reset($result['list'], $result['count']);
    }

    public function store($params)
    {
        $token = $params['token'];
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
        $token = $params['token'];
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminAuthorityFacade::class, $params, 0);
        $result = AdminAuthorityFacade::updateData($data, $id);
        if (!$result) {
            return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }

    public function destroy($params)
    {
        $token = $params['token'];
        $result = AdminAuthorityFacade::deleteAll($params['ids']);
        if (!$result) {
            return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
        }
        return HelperCommon::reset([], 0, 0);
    }

    public function parentData()
    {
        $result = AdminAuthorityFacade::getParent();
        return HelperCommon::reset($result, 0, 0);
    }
}

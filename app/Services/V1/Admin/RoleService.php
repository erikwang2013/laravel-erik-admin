<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminRoleAuthorityFacade,
    App\Support\Facades\V1\Models\AdminRoleInfoFacade,
    Illuminate\Support\Facades\DB,
    App\Common\HelperCommon,
    Exception;

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
        $params['create_time'] = date('Y-m-d H:i:s');
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminRoleInfoFacade::class, $params, 0);
        try {
            DB::beginTransaction();
            $result = AdminRoleInfoFacade::store($data);
            if (!$result) {
                DB::rollBack();
                return  HelperCommon::reset([], 0, 1, trans('public.create_data_fail'));
            }
            //拆分数据，重新组合
            $authority_id = $params['authority_id'];
            $data_authority = [];
            foreach ($authority_id as $k => $v) {
                $data_authority[] = [
                    'role_id' => $params['id'],
                    'authority_id' => $v
                ];
            }
            $result_authority = AdminRoleAuthorityFacade::storeAll($data_authority);
            if (!$result_authority) {
                DB::rollBack();
                return  HelperCommon::reset([], 0, 1, trans('public.create_data_fail'));
            }
            DB::commit();
            return HelperCommon::reset([], 0, 0);
        } catch (Exception $e) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, $e->getMessage());
        }
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

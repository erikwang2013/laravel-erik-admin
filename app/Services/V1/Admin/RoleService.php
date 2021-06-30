<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminRoleAuthorityFacade,
    App\Support\Facades\V1\Models\AdminRoleInfoFacade,
    Illuminate\Support\Facades\DB,
    App\Common\HelperCommon,
    Exception,
    App\Support\Facades\V1\Services\PublicServiceFacade;

class RoleService
{
    public function index($params, $page)
    {
        $token = $params['token'];
        if (false == PublicServiceFacade::checkAuthorityAccess($token)) {
            return  HelperCommon::reset([], 0, 1, trans('public.access_authority_faill'));
        }
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminRoleInfoFacade::class, $params, 0);
        $result = AdminRoleInfoFacade::search($page['page'], $page['limit'], $data);
        return HelperCommon::reset($result['list'], $result['count']);
    }

    public function store($params)
    {
        $token = $params['token'];
        if (false == PublicServiceFacade::checkAuthorityAccess($token)) {
            return  HelperCommon::reset([], 0, 1, trans('public.access_authority_faill'));
        }
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
        $token = $params['token'];
        if (false == PublicServiceFacade::checkAuthorityAccess($token)) {
            return  HelperCommon::reset([], 0, 1, trans('public.access_authority_faill'));
        }
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminRoleInfoFacade::class, $params, 0);
        try {
            DB::beginTransaction();
            $result = AdminRoleInfoFacade::updateData($data, $id);
            if (!$result) {
                DB::rollBack();
                return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
            }
            if (isset($params['authority_id'])) {
                //拆分数据，重新组合
                $authority_id = $params['authority_id'];
                $data_authority = [];
                foreach ($authority_id as $k => $v) {
                    $data_authority[] = [
                        'role_id' => $params['id'],
                        'authority_id' => $v
                    ];
                }
                //删除角色关联的权限
                $delete = AdminRoleAuthorityFacade::deleteAll($params['id']);
                if (!$delete) {
                    DB::rollBack();
                    return  HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
                }
                //重新增加角色关联权限
                $result_authority = AdminRoleAuthorityFacade::storeAll($data_authority);
                if (!$result_authority) {
                    DB::rollBack();
                    return  HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
                }
            }
            DB::commit();
            return HelperCommon::reset([], 0, 0);
        } catch (Exception $e) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, $e->getMessage());
        }
    }

    public function destroy($params)
    {
        $token = $params['token'];
        if (false == PublicServiceFacade::checkAuthorityAccess($token)) {
            return  HelperCommon::reset([], 0, 1, trans('public.access_authority_faill'));
        }
        try {
            DB::beginTransaction();
            $result = AdminRoleInfoFacade::deleteAll($params['ids']);
            if (!$result) {
                DB::rollBack();
                return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
            }
            $result_authority = AdminRoleAuthorityFacade::deleteAll($params['ids']);
            if (!$result_authority) {
                DB::rollBack();
                return  HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
            }
            DB::commit();
            return HelperCommon::reset([], 0, 0);
        } catch (Exception $e) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, $e->getMessage());
        }
    }
}

<?php

namespace App\Services\V1\Backstage\Admin;

use App\Support\Facades\V1\Backstage\Models\AdminFacade,
    App\Support\Facades\V1\Backstage\Models\AdminInfoFacade,
    App\Support\Facades\V1\Backstage\Models\AdminRoleFacade,
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
        $token = $params['token'];
        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminFacade::class, $params, 0);
        $result = AdminFacade::search($token, $pageData['page'], $pageData['limit'], $data);
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
        $token = $params['token'];
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
        $token = $params['token'];
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
    public function destroy($params)
    {
        $token = $params['token'];
        DB::beginTransaction();
        $result = AdminFacade::deleteAll($params['ids']);
        if (!$result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
        }
        $info_result = AdminInfoFacade::deleteAll($params['ids']);
        if (!$info_result) {
            DB::rollBack();
            return HelperCommon::reset([], 0, 1, trans('public.delete_data_fail'));
        }
        DB::commit();
        return HelperCommon::reset([], 0, 0);
    }

    /**
     * 新增管理员角色
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param [type] $params
     * @return void
     */
    public function roleStore($params)
    {
        $token = $params['token'];
        $first = AdminFacade::getFirstData($params['id']);
        //不是超级管理员
        if ($params['authority'] == 1) {
            DB::beginTransaction();
            $role = [];
            foreach ($params['roles'] as $k => $v) {
                $role[] = [
                    'admin_id' => $params['id'],
                    'role_id' => $v,
                ];
            }
            unset($params['roles']);
            unset($k);
            unset($v);
            $result =  AdminRoleFacade::storeAll($role);
            if (!$result) {
                DB::rollBack();
                return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
            }

            if ($first->authority == 0) {
                $result = AdminFacade::updateData(['authority' => 1], $params['id']);
                if (!$result) {
                    DB::rollBack();
                    return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
                }
            }
            DB::commit();
        } else if ($first->authority == 1) {
            $result = AdminFacade::updateData(['authority' => 0], $params['id']);
            if (!$result) {
                return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
            }
        }
        return HelperCommon::reset([], 0, 0);
    }

    /**
     * 更新管理员角色
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param [type] $params
     * @return void
     */
    public function roleUpdate($params)
    {
        $token = $params['token'];
        $first = AdminFacade::getFirstData($params['id']);
        //不是超级管理员
        if ($params['authority'] == 1) {
            DB::beginTransaction();
            $role = [];
            foreach ($params['roles'] as $k => $v) {
                $role[] = [
                    'admin_id' => $params['id'],
                    'role_id' => $v,
                ];
            }
            unset($params['roles']);
            unset($k);
            unset($v);
            $delete = AdminRoleFacade::deleteOne($params['id']);
            if ($delete == false) {
                DB::rollBack();
                return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
            }

            $result =  AdminRoleFacade::storeAll($role);
            if (!$result) {
                DB::rollBack();
                return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
            }

            if ($first->authority == 0) {
                $result = AdminFacade::updateData(['authority' => 1], $params['id']);
                if (!$result) {
                    DB::rollBack();
                    return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
                }
            }
            DB::commit();
        } else if ($first->authority == 1) {
            $result = AdminFacade::updateData(['authority' => 0], $params['id']);
            if (!$result) {
                return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
            }
        }
        return HelperCommon::reset([], 0, 0);
    }

    public function roleDestroy($params)
    {
        $token = $params['token'];
        foreach ($params['ids'] as $k => $v) {
            DB::beginTransaction();
            $first = AdminFacade::getFirstData($v);
            if ($first->authority == 0) {
                $result = AdminFacade::updateData(['authority' => 1], $v);
                if (!$result) {
                    DB::rollBack();
                    return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
                }
            }
            $delete = AdminRoleFacade::deleteOne($v);
            if (false == $delete) {
                DB::rollBack();
                return HelperCommon::reset([], 0, 1, trans('public.update_data_fail'));
            }
            DB::commit();
        }

        return HelperCommon::reset([], 0, 0);
    }
}

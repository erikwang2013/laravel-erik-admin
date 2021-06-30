<?php

namespace App\Services\V1\Backstage\Admin;

use App\Support\Facades\V1\Backstage\Models\AdminFacade,
    App\Common\HelperCommon,
    Illuminate\Support\Facades\Cache,
    Illuminate\Support\Facades\Log;

class PublicService
{

    /**
     * 登录
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-17
     * @param [type] $params
     * @return void
     */
    public function login($params)
    {
        $user_name = $params['user_name'];
        $data = AdminFacade::getPassword($user_name);
        $result = AdminFacade::checkPassword($data->password, $data->hash);
        if (false == $result) {
            return HelperCommon::reset([], 0, 1, trans('admin.login_fail'));
        }
        if ($data->status) {
            return HelperCommon::reset([], 0, 1, trans('admin.login_stop'));
        }
        $token = AdminFacade::setToken($data->id);
        if (false == $token) {
            return HelperCommon::reset([], 0, 1, trans('admin.login_fail'));
        }
        $user_data = [
            'id' => $data->id,
            'name' => $data->name,
            'role' => $data->role,
            'authority_info' => $data->authority_info,
            'phone' => $data->phone,
            'nick_name' => $data->nick_name,
            'email' => $data->email,
            'token' => $token['token']
        ];
        if ($data->authority_status['key'] == 0) {
            $user_data['authority'] = $data->authority_status;
        }
        $data->token_hash = $token['token_hash'];
        $data->token = $token['token'];
        Cache::put($token['token'], json_encode($data), config('app.login_time'));
        return HelperCommon::reset($user_data, 0, 0);
    }



    public function logout($request)
    {
        $token = $request->header('authorization');
        $data = AdminFacade::getLoginTokenInfo($token);
        if (empty($data)) {
            return HelperCommon::reset([], 0, 1, trans('admin.logout_fail'));
        }
        $check = AdminFacade::checkToken($token, $data->token_hash);
        if (false == $check) {
            return HelperCommon::reset([], 0, 1, trans('admin.logout_fail'));
        }
        $update = AdminFacade::updateData(['token_hash' => '', 'access_token' => ''], $data->id);
        if (false == $update) {
            return HelperCommon::reset([], 0, 1, trans('admin.logout_fail'));
        }
        Cache::pull($token);
        return HelperCommon::reset([], 0, 0, trans('admin.logout_true'));
    }

    /**
     *登录用户是否超级管理
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-30
     * @param [type] $token
     * @return void
     */
    public function checkAuthorityAccess($token)
    {
        $admin = AdminFacade::getLoginTokenInfo($token);
        //是否超级管理 0=是 1=否
        if ($admin->authority_status->key == 0) {
            return true;
        }
        return false;
    }
}

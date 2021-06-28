<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminFacade,
    App\Common\HelperCommon;

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
        //$role_ids=AdminFacade::adminRole();
        //var_dump($role_ids);exit;
        var_dump($data);exit;
        $user_data = [
            'id' => $data->id,
            'name' => $data->name,
            'phone' => $data->phone,
            'nick_name' => $data->nick_name,
            'email' => $data->email,
            'token' => $token
        ];
        return HelperCommon::reset($user_data, 0, 0);
    }



    public function logout($request)
    {
        $token = $request->header('authorization');
        $data = AdminFacade::getTokenHash($token);
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
        return HelperCommon::reset([], 0, 0, trans('admin.logout_true'));
    }
}

<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminFacade,
    App\Common\HelperCommon,
    Illuminate\Support\Str;

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
        //$token = md5($data->name . $data->id . time());
        $token = Str::random(30);
        $token_hash = AdminFacade::setToken($token);
        $update = AdminFacade::updateData(['token_hash' => $token_hash, 'access_token' => $token], $data->id);
        if (false == $update) {
            return HelperCommon::reset([], 0, 1, trans('admin.login_fail'));
        }
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
}

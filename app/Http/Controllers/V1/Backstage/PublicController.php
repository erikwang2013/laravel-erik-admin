<?php

namespace App\Http\Controllers\V1\Backstage;

use App\Http\Controllers\Controller,
    App\Common\HelperCommon,
    App\Support\Facades\V1\Models\BaseValidationFacade,
    Illuminate\Http\Request,
    App\Support\Facades\V1\Services\PublicServiceFacade;

class PublicController extends Controller
{
    /**
     * 登录
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-16
     * @return voidW
     */
    public function login(Request $request)
    {
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'login')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        return PublicServiceFacade::login($params);
    }

    /**
     * 登出
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-16
     * @return void
     */
    public function logout(Request $request)
    {
        return PublicServiceFacade::logout($request);
    }

    /**
     * 验证码
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-16
     * @return void
     */
    public function verificationCode()
    {
    }
}

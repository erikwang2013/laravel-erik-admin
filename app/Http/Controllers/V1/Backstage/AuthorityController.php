<?php

namespace App\Http\Controllers\V1\Backstage;

use App\Http\Controllers\Controller,
    App\Support\Facades\V1\Models\BaseValidationFacade,
    App\Common\HelperCommon,
    Illuminate\Http\Request,
    App\Support\Facades\V1\Services\AuthorityServiceFacade;

class AuthorityController extends Controller
{
    public function index(Request $request)
    {
    }

    public function store(Request $request)
    {
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'store')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }

        //生成唯一id
        $id = HelperCommon::getCreateId();
        $params['id'] = $id;

        //过滤存在的数据
        $data = HelperCommon::filterKey(AdminFacade::class, $params, 0);
        return AuthorityServiceFacade::store($data, $params);
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}

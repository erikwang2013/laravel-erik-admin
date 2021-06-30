<?php

namespace App\Http\Controllers\V1\Backstage;

use App\Http\Controllers\Controller,
    App\Support\Facades\V1\Models\BaseValidationFacade,
    App\Common\HelperCommon,
    Illuminate\Http\Request,
    Illuminate\Support\Facades\Validator,
    App\Support\Facades\V1\Services\AuthorityServiceFacade;

class AuthorityController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'index')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        //验证分页
        $pageData = [
            'page' => isset($params['page']) ? $params['page'] : config('app.page'),
            'limit' => isset($params['limit']) ? $params['limit'] : config('app.limit')
        ];
        if (!BaseValidationFacade::check($pageData)) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        $params['token'] = $this->setLoginToken;
        return AuthorityServiceFacade::index($params, $pageData);
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
        $params['token'] = $this->setLoginToken;
        return AuthorityServiceFacade::store($params);
    }

    public function update(Request $request, $id)
    {
        $request->input('id', $id);
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'update')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        unset($params['id']);
        $params['token'] = $this->setLoginToken;
        return AuthorityServiceFacade::update($params, $id);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $ids = explode(',', $id);
        foreach ($ids as $k => $v) {
            $validator = Validator::make(['id' => $v], ['id' => 'numeric|min:19|required']);
            if ($validator->fails()) {
                return HelperCommon::reset([], 0, 1, $validator->errors());
            }
        }
        $params['token'] = $this->setLoginToken;
        $params['ids'] = $ids;
        return AuthorityServiceFacade::destroy($params);
    }

    public function parentData()
    {
        return AuthorityServiceFacade::parentData();
    }
}

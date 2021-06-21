<?php

namespace App\Http\Controllers\V1\Backstage;

use  App\Http\Controllers\Controller,
    Illuminate\Http\Request,
    App\Common\HelperCommon,
    Illuminate\Support\Facades\Validator,
    App\Support\Facades\V1\Models\BaseValidationFacade,
    App\Support\Facades\V1\Services\RoleServiceFacade;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'index')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        if (isset($params['start_time']) && isset($params['end_time'])) {
            $params['create_time'] = [$params['start_time'], $params['end_time']];
        }
        //验证分页
        $pageData = [
            'page' => isset($params['page']) ? $params['page'] : config('app.page'),
            'limit' => isset($params['limit']) ? $params['limit'] : config('app.limit')
        ];
        if (!BaseValidationFacade::check($pageData)) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }

        return RoleServiceFacade::index($params, $pageData);
    }

    public function store(Request $request)
    {
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'store')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }

        $authority_id = explode(',', $params['authority_id']);
        foreach ($authority_id as $k => $v) {
            $validator = Validator::make(['authority_id' => $v], ['authority_id' => 'size:19|required']);
            if ($validator->fails()) {
                return HelperCommon::reset([], 0, 1, $validator->errors());
            }
        }
        $params['authority_id'] = $authority_id;
        //生成唯一id
        $id = HelperCommon::getCreateId();
        $params['id'] = $id;
        return RoleServiceFacade::store($params);
    }

    public function update(Request $request, $id)
    {
        $request->input('id', $id);
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'update')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        if (isset($params['authority_id'])) {
            $authority_id = explode(',', $params['authority_id']);
            foreach ($authority_id as $k => $v) {
                $validator = Validator::make(['authority_id' => $v], ['authority_id' => 'size:19|required']);
                if ($validator->fails()) {
                    return HelperCommon::reset([], 0, 1, $validator->errors());
                }
            }
            $params['authority_id'] = $authority_id;
        }
        unset($params['id']);
        return RoleServiceFacade::update($params, $id);
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
        return RoleServiceFacade::destroy($ids);
    }
}

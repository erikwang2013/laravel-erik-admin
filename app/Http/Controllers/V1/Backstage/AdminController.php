<?php

namespace App\Http\Controllers\V1\Backstage;

use App\Http\Controllers\Controller,
    Illuminate\Http\Request,
    App\Common\HelperCommon,
    App\Support\Facades\V1\Models\BaseValidationFacade,
    Illuminate\Support\Facades\Validator,
    App\Support\Facades\V1\Services\AdminServiceFacade;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return AdminServiceFacade::index($params, $pageData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        return AdminServiceFacade::store($params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->input('id', $id);
        $params = $request->input();
        //$params['id'] = $id;
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'update')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        unset($params['id']);
        return AdminServiceFacade::update($params, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $ids = explode(',', $id);
        foreach ($ids as $k => $v) {
            $validator = Validator::make(['id' => $v], ['id' => 'size:19|required']);
            if ($validator->fails()) {
                return HelperCommon::reset([], 0, 1, $validator->errors());
            }
        }
        return AdminServiceFacade::destroy($ids);
    }


    public function roleStore(Request $request)
    {
        $params = $request->input();
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'roleStore')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        if ($params['authority'] == 1) {
            $ids = explode(',', $params['role_id']);
            foreach ($ids as $k => $v) {
                $validator = Validator::make(['role_id' => $v], ['role_id' => 'size:19|required']);
                if ($validator->fails()) {
                    return HelperCommon::reset([], 0, 1, $validator->errors());
                }
            }
            $params['roles'] = $ids;
            unset($params['role_id']);
        }
        return AdminServiceFacade::roleStore($params);
    }

    public function roleUpdate(Request $request, $id)
    {
        $params = $request->input();
        $params['id'] = $id;
        //校验数据
        if (!BaseValidationFacade::validateRequest($request, 'roleUpdate')) {
            return HelperCommon::reset([], 0, 1, BaseValidationFacade::getError());
        }
        if ($params['authority'] == 1) {
            $ids = explode(',', $params['role_id']);
            foreach ($ids as $k => $v) {
                $validator = Validator::make(['role_id' => $v], ['role_id' => 'size:19|required']);
                if ($validator->fails()) {
                    return HelperCommon::reset([], 0, 1, $validator->errors());
                }
            }
            $params['roles'] = $ids;
            unset($params['role_id']);
        }
        return AdminServiceFacade::roleUpdate($params);
    }

    /**
     * 删除管理员角色
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-21
     * @param Request $request
     * @return void
     */
    public function roleDestroy(Request $request)
    {
        $params = $request->input();
        $params['authority'] = 1;
        $ids = explode(',', $params['id']);
        foreach ($ids as $k => $v) {
            $validator = Validator::make(['id' => $v], ['id' => 'size:19|required']);
            if ($validator->fails()) {
                return HelperCommon::reset([], 0, 1, $validator->errors());
            }
        }
        $params['ids'] = $ids;
        unset($params['id']);
        return AdminServiceFacade::roleDestroy($params);
    }
}

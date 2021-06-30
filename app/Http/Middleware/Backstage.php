<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request,
    App\Support\Facades\V1\Backstage\Models\AdminFacade,
    App\Common\HelperCommon;


class Backstage
{
    public $login_info;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = htmlentities($request->header('authorization'), ENT_QUOTES);
        if (strlen($token) != 88) {
            return response()->json(HelperCommon::reset([], 0, 1, trans('admin.check_token_fail')));
        }
        $data = AdminFacade::getLoginTokenInfo($token);
        if (false == $data) {
            return response()->json(HelperCommon::reset([], 0, 1, trans('admin.check_token_select')));
        }
        $check = AdminFacade::checkToken($token, $data->token_hash);
        if (false == $check) {
            return response()->json(HelperCommon::reset([], 0, 1, trans('admin.check_token_fail')));
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request,
    App\Support\Facades\V1\Models\AdminFacade,
    App\Common\HelperCommon,
    Illuminate\Http\Response;


class Backstage
{
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
        $token = $request->header('authorization');
        $data = AdminFacade::getTokenHash($token);
        if (empty($data)) {
            echo json_encode((HelperCommon::reset([], 0, 1, trans('admin.check_token_select'))));
            exit;
        }
        $check = AdminFacade::checkToken($token, $data->token_hash);
        if (false == $check) {
            echo json_encode(HelperCommon::reset([], 0, 1, trans('admin.check_token_fail')));
            exit;
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\V1\Backstage;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests,
    Illuminate\Foundation\Bus\DispatchesJobs,
    Illuminate\Foundation\Validation\ValidatesRequests,
    Illuminate\Routing\Controller as BaseController,
    Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $setLoginToken;
    public function __construct(Request $request)
    {
        $this->setLoginToken = htmlentities($request->header('authorization'), ENT_QUOTES);
    }
}

<?php

namespace App\Support\Facades\V1\Services;

use Illuminate\Support\Facades\Facade;

class AdminServiceFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Services\V1\Admin\AdminService';
    }
}

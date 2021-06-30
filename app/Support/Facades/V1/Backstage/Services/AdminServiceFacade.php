<?php

namespace App\Support\Facades\V1\Backstage\Services;

use Illuminate\Support\Facades\Facade;

class AdminServiceFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Services\V1\Backstage\Admin\AdminService';
    }
}

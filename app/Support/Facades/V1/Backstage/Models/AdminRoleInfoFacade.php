<?php

namespace App\Support\Facades\V1\Backstage\Models;

use Illuminate\Support\Facades\Facade;

class AdminRoleInfoFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Models\V1\Backstage\AdminRoleInfo';
    }
}

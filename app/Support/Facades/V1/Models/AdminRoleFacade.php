<?php

namespace App\Support\Facades\V1\Models;

use Illuminate\Support\Facades\Facade;

class AdminRoleFacade extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'App\Models\V1\AdminRole';
    }
}

<?php

namespace App\Support\Facades\V1\Models;

use Illuminate\Support\Facades\Facade;

class AdminInfoFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Models\V1\AdminInfo';
    }
}

<?php

namespace App\Support\Facades\V1\Models;

use Illuminate\Support\Facades\Facade;

class ConfigFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Models\V1\Config';
    }
}

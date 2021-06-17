<?php

namespace App\Support\Facades\V1\Services;

use Illuminate\Support\Facades\Facade;

class PublicServiceFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Services\V1\Admin\PublicService';
    }
}

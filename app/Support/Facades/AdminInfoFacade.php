<?php
namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class AdminInfoFacade extends Facade{

    public static function getFacadeAccessor()
    {
        return 'App\Models\V1\Admin\AdminInfo';
    }

}
<?php

namespace App\Support\Facades\V1\Backstage\Models;

use Illuminate\Support\Facades\Facade;

class BaseValidationFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Http\Validations\V1\Backstage\BaseValidation';
    }
}

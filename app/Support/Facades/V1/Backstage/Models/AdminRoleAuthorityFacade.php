<?php

namespace App\Support\Facades\V1\Backstage\Models;

use Illuminate\Support\Facades\Facade;

class AdminRoleAuthorityFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Models\V1\Backstage\AdminRoleAuthority';
    }
}

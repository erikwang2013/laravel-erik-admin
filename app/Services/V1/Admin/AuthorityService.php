<?php

namespace App\Services\V1\Admin;

use App\Support\Facades\V1\Models\AdminAuthorityFacade,
    App\Common\HelperCommon;

class AuthorityService
{
    public function index($data, $page)
    {
        $result = AdminAuthorityFacade::search($page['page'], $page['limit'], $data);
        return HelperCommon::reset($result['list'], $result['count']);
    }

    public function store($data, $params)
    {
    }

    public function update($params, $id)
    {
    }

    public function destroy($id)
    {
    }
}

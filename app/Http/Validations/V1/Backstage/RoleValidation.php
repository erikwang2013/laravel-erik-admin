<?php

namespace App\Http\Validations\V1\Backstage;

class RoleValidation
{
    public function index()
    {
        return [
            'rules' => [
                'id' => 'numeric|size:19',
                'parent_id' => 'numeric|min:0|max:19',
                'status' => 'in:1,0',
                'show' => 'in:1,0',
                'name' => 'alpha_dash|min:2|max:10'
            ],
            'messages' => []
        ];
    }

    public function store()
    {
        return [
            'rules' => [
                'name' => 'alpha_dash|min:2|max:10|required'
            ],
            'messages' => []
        ];
    }

    public function update()
    {
        return [
            'rules' => [
                'parent_id' => 'numeric|min:0|max:19',
                'status' => 'in:1,0',
                'show' => 'in:1,0',
                'code' => 'alpha_dash',
                'name' => 'alpha_dash|min:2|max:10'
            ],
            'messages' => []
        ];
    }
}

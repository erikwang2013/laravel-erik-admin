<?php

namespace App\Http\Validations\V1\Backstage;

class RoleValidation
{
    public function index()
    {
        return [
            'rules' => [
                'id' => 'numeric|size:19',
                'status' => 'in:1,0',
                'name' => 'alpha_dash|min:2|max:10',
                'start_time' => 'date_format:Y-m-d H:i:s',
                'end_time' => 'date_format:Y-m-d H:i:s'
            ],
            'messages' => []
        ];
    }

    public function store()
    {
        return [
            'rules' => [
                'name' => 'alpha_dash|min:2|max:10|required',
                'status' => 'in:1,0|required',
            ],
            'messages' => []
        ];
    }

    public function update()
    {
        return [
            'rules' => [
                'status' => 'in:1,0',
                'name' => 'alpha_dash|min:2|max:10'
            ],
            'messages' => []
        ];
    }
}

<?php

namespace App\Http\Validations\V1\Backstage;

class PublicValidation
{
    public function login()
    {
        return [
            'rules' => [
                'user_name' => 'bail|required|max:30',
                'password' => 'bail|required|alpha_num|max:152'
            ],
            'messages' => []
        ];
    }
}

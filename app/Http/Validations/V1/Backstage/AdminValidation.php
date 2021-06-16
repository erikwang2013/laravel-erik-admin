<?php

namespace App\Http\Validations\V1\Backstage;

class AdminValidation
{
    public function index()
    {
        return [
            'rules' => [
                'id' => 'numeric|min:19',
                'name' => 'alpha_dash|min:18',
                'email' => 'email|min:50',
                'phone' => 'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status' => 'in:1,0',
                'nick_name' => 'regex:/^[一-龥]{0,}$/|alpha_dash',
                'real_name' => 'regex:/^[一-龥]{0,}$/',
                'sex' => 'in:0,1'
            ],
            'messages' => [
                'nick_name' => trans('admin.nick_name_fail'),
                'real_name' => trans('admin.real_name_fail')
            ],
        ];
    }

    public function store()
    {
        return [
            'rules' => [
                'name' => 'alpha_dash|between:3,18|required',
                'password' => 'alpha_dash|between:6,18|required',
                'email' => 'email|between:6,18',
                'phone' => 'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status' => 'in:0,1|required',
                'nick_name' => 'regex:/^[一-龥]{0,}$/|alpha_dash|required',
                'real_name' => 'regex:/^[一-龥]{0,}$/',
                'sex' => 'in:0,1|required',
                'age' => 'numeric|size:3|between:1,120',
                'year' => 'numeric|size:4|between:1900,2140',
                'month' => 'numeric|size:2|between:1,12',
                'day' => 'numeric|size:2|between:1,31',
                'img' => 'image|size:10'
            ],
            'messages' => [],
        ];
    }

    public function update()
    {
        return [
            'rules' => [
                'id' => 'numeric|min:19',
                'name' => 'alpha_dash|between:3,18|required',
                'email' => 'email|between:6,18',
                'phone' => 'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status' => 'in:0,1|required',
                'nick_name' => 'regex:/^[一-龥]{0,}$/|alpha_dash|required',
                'real_name' => 'regex:/^[一-龥]{0,}$/',
                'sex' => 'in:0,1|required',
                'age' => 'numeric|size:3|between:1,120',
                'year' => 'numeric|size:4|between:1900,2140',
                'month' => 'numeric|size:2|between:1,12',
                'day' => 'numeric|size:2|between:1,31',
                'img' => 'image|size:10'
            ],
            'messages' => [],
        ];
    }
}

<?php

namespace App\Http\Validations\V1\Backstage;

class AdminValidation
{
    public function index()
    {
        return [
            'rules' => [
                'id' => 'numeric|size:19',
                'name' => 'alpha_dash|min:2|max:10',
                'email' => 'email|min:7|max:18',
                'phone' => 'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status' => 'in:1,0',
                'nick_name' => 'regex:/^[一-龥]{0,}$/|alpha_dash|min:1|max:10',
                'real_name' => 'regex:/^[一-龥]{0,}$/|min:2|max:6',
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
                'name' => 'alpha_dash|min:2|max:10|required',
                'password' => 'alpha_dash|min:6|max:18|required',
                'email' => 'email|min:7|max:18',
                'phone' => 'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status' => 'in:0,1|required',
                'nick_name' => 'regex:/^[一-龥]{0,}$/|alpha_dash|required|min:1|max:10',
                'real_name' => 'regex:/^[一-龥]{0,}$/|min:2|max:6',
                'sex' => 'in:0,1|required',
                'year' => 'numeric|between:1919,2050|required',
                'month' => 'numeric|between:1,12|required',
                'day' => 'numeric|between:1,31|required',
                'img' => 'image|size:50'
            ],
            'messages' => [
                'nick_name' => trans('admin.nick_name_fail'),
                'real_name' => trans('admin.real_name_fail')
            ],
        ];
    }

    public function update()
    {
        return [
            'rules' => [
                'id' => 'numeric|size:19',
                'name' => 'alpha_dash|min:2|max:10',
                'email' => 'email|min:7|max:18',
                'phone' => 'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status' => 'in:0,1',
                'nick_name' => 'regex:/^[一-龥]{0,}$/|alpha_dash|min:1|max:10',
                'real_name' => 'regex:/^[一-龥]{0,}$/|min:2|max:6',
                'sex' => 'in:0,1',
                'year' => 'numeric|between:1919,2050',
                'month' => 'numeric|between:1,12',
                'day' => 'numeric|between:1,31',
                'img' => 'image|size:50'
            ],
            'messages' => [
                'nick_name' => trans('admin.nick_name_fail'),
                'real_name' => trans('admin.real_name_fail')
            ],
        ];
    }

    public function roleStore()
    {
        return [
            'rules' => [
                'id' => 'size:19|required',
                'authority' => 'in:0,1|required',
                'role_id' => 'required'
            ],
            'messages' => []
        ];
    }

    public function roleUpdate()
    {
        return [
            'rules' => [
                'id' => 'size:19',
                'authority' => 'in:0,1'
            ],
            'messages' => []
        ];
    }

    public function roleDestroy()
    {
        return [
            'rules' => [],
            'messages' => []
        ];
    }
}

<?php
namespace App\Http\Validations\V1\Admin;

class AdminValidation
{
    public function index (){
        return [
            'rules' => [
                'id'=>'numeric|min:19',
                'name'=>'alpha_dash|min:18',
                'email'=>'email|min:50',
                'phone'=>'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status'=>'in:1,0'
            ],
            'message' => [

            ],
        ];
    }

    public function store (){
        return [
            'rules' => [
                'name'=>'alpha_dash|min:18|required',
                'email'=>'email|size:50',
                'phone'=>'regex:/^[1][3456789][0-9]{9}$/|size:11',
                'status'=>'in:1,0|required'
            ],
            'message' => [

            ],
        ];
    }
}
<?php

namespace App\Validate\V1\Backstage;

use  App\Http\Validations\V1\Backstage\BaseValidation;

class PageValidator extends BaseValidation
{
    //验证规则
    protected $rule = [
        'page' => 'numeric|required',
        'limit' => 'numeric|required',
    ];

    //验证提示消息
    protected $message = [];

    //场景自定义
    protected $scene = [];
}

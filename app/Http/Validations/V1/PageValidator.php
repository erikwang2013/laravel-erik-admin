<?php
namespace App\Validate\V1;
use  App\Validate\BaseValidator;
class PageValidator extends BaseValidator
{
        //验证规则
        protected $rule=[
            'page'=>'numeric',
            'limit'=>'numeric',
        ];
    
        //验证提示消息
        protected $message=[];
    
        //场景自定义
        protected $scene=[];
}
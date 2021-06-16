<?php

namespace App\Http\Validations\V1;

use Illuminate\Http\Request,
    App\Common\HelperCommon,
    Illuminate\Support\Facades\Validator;


class BaseValidation
{
    //错误提示消息
    protected $error = [];

    public function check($data = [], $rules = [], $messages = [])
    {

        $validator = Validator::make($data, count($rules) > 0 ? $rules : [
            'page' => 'numeric|required',
            'limit' => 'numeric|required',
        ], $messages);
        if ($validator->fails()) {
            $this->error = $validator->errors()->first();
            return false;
        }
        return !empty($this->error) ? false : true;
    }

    public function validateRequest(Request $request, $name = null)
    {
        if (!$validator = $this->getValidator($request, $name)) {
            return;
        }
        $rules    = HelperCommon::array_get($validator, 'rules', []);
        $messages = HelperCommon::array_get($validator, 'messages', []);
        $validator = Validator::make($request->input(), $rules, $messages);
        if ($validator->fails()) {
            $this->error = $validator->errors()->first();
            return false;
        }
        return !empty($this->error) ? false : true;
    }

    protected function getValidator(Request $request, $name = null)
    {
        $route = $request->route();
        $action = $route->action;
        list($controller, $method) = explode('@', $action['uses']);
        $method = $name ?: $method;

        $class = str_replace('Controller', 'Validation', $controller);
        if (!class_exists($class) || !method_exists($class, $method)) {
            return false;
        }

        return call_user_func([new $class, $method]);
    }

    public function getError()
    {
        return $this->error;
    }
}

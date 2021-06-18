<?php

namespace App\Common;

use  App\Common\Snowflake;

class HelperCommon
{
    /**
     * 过滤存在的字段
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-08 09:49:21
     * @param [type] $model
     * @param [type] $data 请求数据
     * @param integer $status 0返回数组 1覆盖对象
     * @return void|array
     */
    public static function filterKey($model, $data, $status = 1)
    {
        if ($status == 0) {
            $attributes = $model::findWhere();
            $data_info = [];
            foreach ($data as $name => $value) {
                if (in_array($name, $attributes)) {
                    $data_info[$name] = $value;
                }
            }
            return $data_info;
        } else {
            $attributes = $model::findWhere();
            foreach ($data as $name => $value) {
                if (in_array($name, $attributes)) {
                    $model::$name = $value;
                }
            }
        }
    }
    /**
     * 返回数据格式定义
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-14 11:31:40
     * @param array $data
     * @param string $msg
     * @param integer $code
     * @param integer $count
     * @return void
     */
    public static function reset($data = [], $count = 0, $code = 0, $msg = 'ok')
    {
        return [
            'code' => $code,
            'count' => $count,
            'msg' => $msg,
            'data' => $data,
        ];
    }
    /**
     * 生成id
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @Url https://erik.xyz
     * @DateTime 2021-04-14 19:26:34
     * @return void
     */
    public static function getCreateId()
    {
        $snowflake_config = config('app.snowflake');
        $snowflake = new Snowflake($snowflake_config['data_center_id'], $snowflake_config['unix_id']);
        return $snowflake->generateId();
    }

    public static function array_get($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return value($default);
            }

            $array = $array[$segment];
        }
        return $array;
    }

    /**
     * 设置数组指定键
     *
     * @Author erik
     * @Email erik@erik.xyz
     * @address https://erik.xyz
     * @Date 2021-06-18
     * @param [type] $arr
     * @param [type] $key
     * @return void
     */
    public static function array_keys_header($arr, $key)
    {
        $result = [];
        foreach ($arr as $k => $v) {
            $result[$v[$key]] = $v;
        }
        return $result;
    }
}

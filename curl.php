<?php

namespace Lackone;

class Curl
{
    /**
     * @param $url 请求的地址
     * @param string $params 请求的参数(string或者array)
     * @param array $header 请求的头信息
     * @param int $timeout 超时时间
     * @return bool|mixed
     */
    public static function get($url, $params = '', $header = [], $timeout = 0)
    {
        return self::_request($url, $params, 'get', $header, $timeout);
    }

    /**
     * @param $url 请求的地址
     * @param string $params 请求的参数(string或者array)
     * @param array $header 请求的头信息
     * @param int $timeout 超时时间
     * @return bool|mixed
     */
    public static function post($url, $params = '', $header = [], $timeout = 0)
    {
        return self::_request($url, $params, 'post', $header, $timeout);
    }

    /**
     * @param $url 请求的地址
     * @param string $type 请求的类型(get或post)
     * @param string $params 请求的参数(string或者array)
     * @param string $header 请求的头信息
     * @param int $timeout 超时时间
     */
    private static function _request($url, $params = '', $type = 'get', $header = [], $timeout = 0)
    {
        $curl = curl_init();

        //兼容https
        if (stripos($url, 'https://')) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSLVERSION, 1);
        }
        //设置返回原生raw内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //设置不返回头文件的信息
        curl_setopt($curl, CURLOPT_HEADER, false);
        //设置请求头信息
        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        //设置返回body
        curl_setopt($curl, CURLOPT_NOBODY, false);
        //设置超时时间
        if ($timeout > 0) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        }
        //请求类型转为大写
        $type = strtoupper($type);
        switch ($type) {
            case 'POST':
                //设置为post请求
                curl_setopt($curl, CURLOPT_POST, true);
                if (is_array($params) && !empty($params)) {
                    foreach ($params as $key => $val) {
                        if (is_string($val) && strpos($val, '@') === 0) {
                            $filePath = ltrim($val, '@');
                            if (class_exists('\CURLFile')) {
                                $params[$key] = new \CURLFile(realpath($filePath));
                            } else {
                                $params[$key] = '@' . realpath($filePath);
                            }
                        }
                    }
                }
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case 'GET':
                if (is_array($params) && !empty($params)) {
                    $params = http_build_query($params);
                }
                $url = rtrim($url, '?') . $params;
                break;
            default :
                return false;
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}

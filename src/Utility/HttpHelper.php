<?php


namespace AdminBase\Utility;

use Exception;

class HttpHelper
{
    /**
     * 上传文件
     * @param $url
     * @param $filePath
     * @return bool|string
     */
    public static function uploadFile($url, $filePath)
    {
        $ch = curl_init();

        //post数据，使用@符号，curl就会认为是有文件上传
        $curlPost = array('files[]' => new \CURLFile($filePath));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true); //POST提交
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * 发送get请求
     * @param $url
     * @param array $header
     * @return bool|string
     * @throws Exception
     */
    public static function get($url, $header = ['Accept: application/json'])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 超时设置,以秒为单位
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $data = curl_exec($curl);
        if (curl_error($curl)) {
            throw new Exception("request get error:".curl_error($curl));
        } else {
            curl_close($curl);
            return $data;
        }
    }

    /**
     * 发送post请求
     * @param $url
     * @param array $data
     * @param array $header
     * @return array|bool|string
     * @throws Exception
     */
    public static function post($url, $data = [], $header = ['Accept: application/json'])
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // 超时设置
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false );

        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $data = curl_exec($curl);
        if (curl_error($curl)) {
            throw new Exception("request post error:".curl_error($curl));
        } else {
            curl_close($curl);
            return $data;
        }
    }
}
<?php


namespace AdminBase\Utility;


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
        $curlPost = array('files[]'=>new \CURLFile($filePath));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true); //POST提交
        curl_setopt($ch, CURLOPT_POSTFIELDS,$curlPost);
        $data =curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
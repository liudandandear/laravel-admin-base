<?php


namespace AdminBase\Common;


class AES
{
    /**
     * 秘钥
     * @var
     */
    protected static $key;

    /**
     * 加密方式
     * @var string
     */
    protected static $method = 'AES-128-CBC';

    public function __construct()
    {
        self::$key = config('custom.aes_key');
    }

    /**
     * AES加密算法
     * @param string $content 加密内容
     * @return string
     */
    public static function encrypt($content)
    {
        $result = openssl_encrypt($content, self::$method, self::$key, OPENSSL_RAW_DATA, self::$key);
        return base64_encode($result);
    }

    /**
     * AES解密算法
     * @param string $content 密文
     * @return string
     */
    public static function decrypt($content)
    {
        $content = base64_decode($content);
        return openssl_decrypt($content, self::$method, self::$key, OPENSSL_RAW_DATA, self::$key);
    }
}

<?php

namespace AdminBase\Utility;

use Google2FA;

class Google2FaHelper
{
    public static $secretSessionKey = '2FA_secret';

    public static function getSecretKey($size = 32){
        return Google2FA::generateSecretKey($size);
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getInlineUrl($key)
    {
        return Google2FA::getQRCodeInline(
            config('app.name', 'admin'),
            config('custom.google2fa_email', 'google2fa@pragmarx.com'),
            $key,
            200
        );
    }

    /**
     * 验证
     * @param $key
     * @param $code
     * @return mixed
     */
    public static function verify($key, $code){
        return Google2FA::verifyKey($key, $code);
    }
}

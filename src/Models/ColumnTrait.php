<?php


namespace AdminBase\Models;


Trait ColumnTrait
{
    public static function getCacheKey($key = 'List')
    {
        return basename(str_replace('\\', '/', self::class)) . $key;
    }
}
<?php


namespace AdminBase\Traits;


/**
 * 单例
 * Trait Singleton
 * @package App\Traits
 */
trait Singleton
{
    private static $instance;

    static function getInstance(...$args)
    {
        if(!isset(self::$instance)){
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}

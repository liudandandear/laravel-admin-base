<?php


namespace AdminBase\Adapters;


use League\Flysystem\Adapter\Local;

/**
 * 远程资源路劲适配器
 * Class FastDFSAdapter
 * @package App\Adapters
 */
class FastDFSAdapter extends Local
{
    public function getUrl($path){
        if(strpos($path, 'http://') !== false || strpos($path, 'https://') !== false) {
            return $path;
        }else{
            return '/upload/'.$path;
        }
    }
}
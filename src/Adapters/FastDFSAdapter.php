<?php


namespace AdminBase\Adapters;


use AdminBase\Utility\HttpHelper;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Config;
use League\Flysystem\Exception;

/**
 * go-fastdfs 适配器
 * Class FastDFSAdapter
 * @package App\Adapters
 */
class FastDFSAdapter extends AbstractAdapter
{
    const SESSION_KEY = 'fastdfs_file_url';

    private $api;

    /**
     * FastDFSAdapter constructor.
     * @param string $root
     * @param string $api
     * @throws Exception
     */
    public function __construct(string $root, string $api)
    {
        $root = is_link($root) ? realpath($root) : $root;
        $this->ensureDirectory($root);

        $this->setPathPrefix($root);
        $this->api = $api;
    }

    public function getUrl($path){
        if(strpos($path, 'http://') !== false || strpos($path, 'https://') !== false) {
            return $path;
        }else if (strpos($path, 'upload') !== false){
            return $path;
        }else{
            return '/upload/'.$path;
        }
    }

    public function write($path, $contents, Config $config)
    {

    }

    /**
     * @param string $path
     * @param resource $resource
     * @param Config $config
     * @return array|bool|false
     * @throws Exception
     */
    public function writeStream($path, $resource, Config $config)
    {
        $location = $this->applyPathPrefix($path);
        $this->ensureDirectory(dirname($location));
        $stream = fopen($location, 'w+b');

        if ( ! $stream || stream_copy_to_stream($resource, $stream) === false || ! fclose($stream)) {
            return false;
        }

        $type = 'file';

        $path = HttpHelper::uploadFile($this->api, $location, $err);
        if($path === false ){
            return false;
        }
        session([self::SESSION_KEY => $path]);
        //删除本地文件
        @unlink($location);
        return compact('type', 'path');
    }

    public function update($path, $contents, Config $config)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param string $path
     * @param resource $resource
     * @param Config $config
     * @return array|bool|false
     * @throws Exception
     */
    public function updateStream($path, $resource, Config $config)
    {
        return $this->writeStream($path, $resource, $config);
    }

    public function rename($path, $newpath)
    {

    }

    public function copy($path, $newpath)
    {

    }

    public function delete($path)
    {

    }

    public function deleteDir($dirname)
    {

    }

    public function createDir($dirname, Config $config)
    {

    }

    public function setVisibility($path, $visibility)
    {

    }

    public function has($path)
    {
        return true;
    }

    public function read($path)
    {

    }

    public function readStream($path)
    {

    }

    public function listContents($directory = '', $recursive = false)
    {

    }

    public function getMetadata($path)
    {

    }

    public function getSize($path)
    {

    }

    public function getMimetype($path)
    {

    }

    public function getTimestamp($path)
    {

    }

    public function getVisibility($path)
    {

    }

    /**
     * Ensure the root directory exists.
     *
     * @param string $root root directory path
     *
     * @return void
     *
     * @throws Exception in case the root directory can not be created
     */
    protected function ensureDirectory($root)
    {
        if ( ! is_dir($root)) {
            $umask = umask(0);

            if ( ! @mkdir($root, 0755, true)) {
                $mkdirError = error_get_last();
            }

            umask($umask);
            clearstatcache(false, $root);

            if ( ! is_dir($root) || ! is_readable($root)) {
                $errorMessage = $mkdirError['message'] ?? '';
                throw new Exception(sprintf('Impossible to create the root directory "%s". %s', $root, $errorMessage));
            }
        }
    }
}
<?php

namespace AdminBase\RpcServices;


use AdminBase\Common\AES;
use AdminBase\Utility\JsonHelper;
use Exception;

class Service
{
    protected $serviceName;

    protected $action;

    protected $params;

    protected $err = '';

    public function getErr(){
        return $this->err;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return $this
     * @throws Exception
     */
    public function setParams(array $params)
    {
        $this->params = JsonHelper::encode($params);
        return $this;
    }

    /**
     * 发送
     * @return array|bool
     */
    public function send(){
        $params = [
            'command' => 1,//1:请求,2:状态rpc 各个服务的状态
            'request' => [
                'serviceName' => $this->serviceName,
                'action' => $this->action,//行为名称
                'arg' => AES::encrypt($this->params)
            ]
        ];

        $raw = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $fp = stream_socket_client('tcp://'.config('custom.rpc_host'));
        fwrite($fp, pack('N', strlen($raw)) . $raw);//pack数据校验

        $data = fread($fp, 65533);
        //做长度头部校验
        $len = unpack('N', $data);
        $data = substr($data, '4');
        fclose($fp);

        if (strlen($data) != $len[1]) {
            $this->err = '数据错误';
            return false;
        } else {
            $data = json_decode($data, true);
            if(!is_array($data) || !isset($data['status'])) {
                $this->err = '解析错误';
                return false;
            }
            if($data['status'] == 0) {
                return $data['result'];
            }
            $this->err = '请求异常:'.$data['msg'];
            return false;
        }
    }
}
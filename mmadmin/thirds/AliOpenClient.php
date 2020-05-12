<?php
namespace app\mmadmin\thirds;

use yii\base\BaseObject;
use yii\httpclient\Client;
use yii\helpers\Json;

/**
 *
 * @author dungang
 */
abstract class AliOpenClient extends BaseObject
{

    /**
     * http客户端
     *
     * @var Client
     */
    protected static $http_client;

    /**
     * API网关
     *
     * @var string
     */
    public $url = 'http://gw.api.taobao.com/router/rest';

    /**
     * APP密钥
     *
     * @var string
     */
    public $app_secret = '';

    /**
     * 默认的公共参数
     *
     * @var array
     */
    protected $common;

    /**
     * 最后一次请求的参数
     *
     * @var array
     */
    private $_last_params;

    /**
     * 获取单例的httpclient实例
     *
     * @return \yii\httpclient\Client
     */
    public static function getHttpClient()
    {
        if (self::$http_client == null) {
            self::$http_client = new Client();
        }
        return self::$http_client;
    }

    public function init()
    {
        $this->common = $this->prepareCommon();
    }

    /**
     * 签名参数，再参数列表中添加sign的值
     *
     * @param array $params
     *            待签名的参数
     * @return array
     */
    protected function sign($params)
    {
        unset($params['sign']);
        $params = \array_filter($params, function ($v, $k) {
            return null != $v && '' != $v;
        }, ARRAY_FILTER_USE_BOTH);
        \ksort($params);
        $kvs = [];
        foreach ($params as $k => $v) {
            $kvs[] = $k . $v;
        }
        $params['sign'] = strtoupper(md5($this->app_secret . implode('', $kvs) . $this->app_secret));
        return $params;
    }

    protected function get($params)
    {
        return $this->execute($params);
    }

    /**
     * 执行请求
     *
     * @param array $params
     *            请求的所有参数数组
     * @throws \InvalidArgumentException
     * @return NULL
     */
    protected function execute($params)
    {
        $params = $this->sign(\array_merge($this->common, $params));
        $this->_last_params = $params;
        $rsp = self::getHttpClient()->get($this->url, $params)->send();
        if ($rsp->isOk) {
            $data = Json::decode($rsp->getContent());
            $error_response_key = $this->prepareErrorResponseKey($params);
            if (isset($data[$error_response_key])) {
                $error = $data[$error_response_key];
                $msg = isset($error['sub_msg']) ? $error['msg'] . '[' . $error['sub_msg'] . ']' : $error['msg'];
                throw new AliOpenException('MSG => ' . $msg . ' , RequestId => ' . $error['request_id'] . ', URL => ' . $this->getRawUrl(), 500);
            } else {
                $key = $this->prepareSuccessResponseKey($params);
                if (isset($data[$key])) {
                    return $data[$key];
                }
            }
        }
        return null;
    }

    /**
     * 准备公共参数配置
     */
    protected abstract function prepareCommon();

    /**
     * 准备错误请求的状态key
     *
     * @param array $params
     * @return string
     */
    protected abstract function prepareSuccessResponseKey($params);

    /**
     * 准备成功请求的状态key
     *
     * @param array $params
     * @return string
     */
    protected abstract function prepareErrorResponseKey($params);

    /**
     * 获取本次请求的url地址
     *
     * @return string
     */
    public function getRawUrl()
    {
        return $this->url . '?' . \http_build_query($this->_last_params);
    }

    /**
     * 魔法调用API
     *
     * {@inheritdoc}
     * @see \yii\base\BaseObject::__call()
     */
    public function __call($name, $params)
    {
        $params[0]['method'] = \strtolower(preg_replace("/([A-Z])/", ".\\1", $name));
        return \call_user_func_array([
            $this,
            'get'
        ], $params);
    }
}


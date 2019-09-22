<?php

namespace app\kit\thirds;

use yii\base\BaseObject;
use yii\httpclient\Client;
use yii\helpers\Json;

class BaiduAipClient extends BaseObject
{

    public $app_id = '16052326';

    public $client_id = 'qHyzUQLPmdyRNlN85DcDHP0i';

    public $client_secret = 'jrBvPTgU7SIHGYGcEz3ZLvmLH4kKbGgV';

    protected $access_token_url = 'https://aip.baidubce.com/oauth/2.0/token';

    /**
     * http客户端
     *
     * @var \yii\httpclient\Client
     */
    protected $client;

    public function init()
    {
        $this->client = new Client([
            'transport' => 'yii\httpclient\CurlTransport',
            'requestConfig' => [
                'options' => [
                    'SSL_VERIFYPEER' => false
                ]
            ]
        ]);
    }

    public function auth()
    {
        //缓存30天
        return \Yii::$app->cache->getOrSet(
            'baidu.aip.access_token',
            function () {
                $rst = $this->client->get($this->access_token_url, [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret
                ], [
                    'Content-Type' => 'application/json'
                ])
                    ->send();
                if ($rst->isOk) {
                    $data = Json::decode($rst->content);
                    if (!isset($data['error'])) {
                        return $data;
                    }
                }
                return false;
            },
            2592000
        );
    }
}

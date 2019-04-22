<?php
namespace app\kit\thirds;

use yii\base\BaseObject;
use yii\httpclient\Client;
use yii\helpers\Json;

/**
 * 百度文字合成语音
 *
 * @author dungang
 */
class BaiduTextAudioClient extends BaseObject
{

    public $url = 'http://tsn.baidu.com/text2audio';
    
    public $app_id = '16052326';

    public $client_id = 'qHyzUQLPmdyRNlN85DcDHP0i';

    public $client_secret = 'jrBvPTgU7SIHGYGcEz3ZLvmLH4kKbGgV';

    public $data_prefix = 'data:audio/x-mpeg;base64,';

    protected $combile_conf = [
        'lan' => 'zh',
        'spd' => 5,
        'pit' => 5,
        'vol' => 5,
        'per' => 4,
        'ctp' => 1
    ];

    protected $access_token_url = 'https://aip.baidubce.com/oauth/2.0/token';

    protected $client;

    public function init()
    {
        $this->client = new Client();
    }
    
    public function setConfig($config){
        $this->combile_conf = \array_merge($this->combile_conf,$config);
        return $this;
    }

    public function auth()
    {
        //缓存30天
        return \Yii::$app->cache->getOrSet('baidu.tts.access_token',
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
                    if (! isset($data['error'])) {
                        return $data;
                    }
                }
                return false;
            }, 2592000);
    }

    public function toAudioBase64($text)
    {
        if ($token = $this->auth()) {
            $data = $this->client->post($this->url, \array_merge($this->combile_conf, [
                'access_token' => $token['access_token'],
                'tex' => \urlencode(\urlencode($text))
            ]))->send();
            if (isset($data['error'])) {
                return false;
            } else {
                return $this->data_prefix . $data['content'];
            }
        }
        return false;
    }

    public function toUrl($text)
    {
        if ($token = $this->auth()) {
            return $this->url . '?' . \http_build_query(\array_merge($this->combile_conf, [
                'access_token' => $token['access_token'],
                'tex' => $text,
                'appid'=>$this->app_id,
                'apikey'=>$this->client_id,
                'cuid'=>\Yii::$app->user->id,
            ]));
        }
        return false;
    }
}


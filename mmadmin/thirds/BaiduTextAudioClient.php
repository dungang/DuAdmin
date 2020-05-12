<?php
namespace app\mmadmin\thirds;

use yii\helpers\Json;

/**
 * 百度文字合成语音
 *
 * @author dungang
 */
class BaiduTextAudioClient extends BaiduAipClient
{
    public $url = 'http://tsn.baidu.com/text2audio';

    public $data_prefix = 'data:audio/x-mpeg;base64,';

    protected $combile_conf = [
        'lan' => 'zh',
        'spd' => 5,
        'pit' => 5,
        'vol' => 5,
        'per' => 4,
        'ctp' => 1
    ];
    
    public function setConfig($config){
        $this->combile_conf = \array_merge($this->combile_conf,$config);
        return $this;
    }

    public function toAudioBase64($text)
    {
        if ($token = $this->auth()) {
            $rsp = $this->client->post($this->url, \array_merge($this->combile_conf, [
                'access_token' => $token['access_token'],
                'tex' => \urlencode(\urlencode($text))
            ]))->send();
            if($rsp->isOk){
                $data = Json::encode($rsp->content);
                if (isset($data['error'])) {
                    return false;
                } else {
                    return $this->data_prefix . $data['content'];
                }
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


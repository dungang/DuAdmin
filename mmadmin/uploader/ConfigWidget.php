<?php
namespace app\mmadmin\uploader;

use Yii;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\View;

class  ConfigWidget extends Widget {

    public $keyName = 'key';

    public $tokenName = 'token';

    public $uploadUrl = '';

    public $deleteUrl = '';

    public $baseUrl = '';

    public function run() {
        if(empty($this->baseUrl)) {
            $this->baseUrl = Yii::$app->request->baseUrl;
        }
        //$this->beforeRun();
        $this->view->registerJs($this->configJs(),View::POS_HEAD);
    }

    public function configJs(){
        return "window.MA = " . Json::encode([
            'uploader'=>[
                'keyName' => $this->keyName,
                'tokenName' => $this->tokenName,
                'uploadUrl' => $this->uploadUrl,
                'deleteUrl' => $this->deleteUrl,
                'baseUrl' => $this->baseUrl . '/',
                // 'getFileUrl'=> new JsExpression("function(response){
                //     return '{$this->baseUrl}/'+ response.key;
                // }")
            ]
        ]);
    }
}
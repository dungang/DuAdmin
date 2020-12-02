<?php
namespace DuAdmin\Uploader;

use DuAdmin\Helpers\MAHelper;
use Yii;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\View;

/**
 * ajax 上传文件前端配置
 * 文件直接传到OSS类服务，而不是服务器中转。
 * 默认是本地文件上传
 *
 * @author dungang
 *        
 */
class ConfigWidget extends Widget
{

    public $keyName = 'key';

    public $tokenName = 'token';

    public $uploadUrl = '';

    public $deleteUrl = '';

    public $baseUrl = '';

    public static $called = false;

    public static function factory()
    {
        if (static::$called == false) {
            $driverName = MAHelper::getSetting('system.storage.driver');
            if (empty($driverName) || $driverName == 'local') {
                static::widget();
            } else {
                if (class_exists($driverName)) {
                    call_user_func([
                        $driverName,
                        'configWidget'
                    ]);
                } else {
                    \Yii::error('System storage driver load error, class not found. ' . $driverName);
                }
                static::$called = true;
            }
        }
    }

    public function run()
    {
        if (empty($this->baseUrl)) {
            $this->baseUrl = Yii::$app->request->baseUrl . '/uploads';
        }
        if (empty($this->uploadUrl)) {
            $this->uploadUrl = Yii::$app->urlManager->createUrl('site/upload');
        }
        $this->view->registerJs($this->configJs(), View::POS_HEAD);
    }

    public function configJs()
    {
        return "window.MA = " . Json::encode([
            'uploader' => [
                'keyName' => $this->keyName,
                'tokenName' => $this->tokenName,
                'uploadUrl' => $this->uploadUrl,
                'deleteUrl' => $this->deleteUrl,
                'baseUrl' => $this->baseUrl . '/'
            ]
        ]);
    }
}

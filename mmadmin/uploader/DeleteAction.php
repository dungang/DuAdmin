<?php

namespace app\mmadmin\uploader;

use app\mmadmin\core\BizException;
use app\mmadmin\helpers\MAHelper;
use app\mmadmin\storage\LocalDriver;
use Yii;
use yii\base\Action;

class DeleteAction extends  Action
{

    public function run()
    {
        $driver = MAHelper::getSetting('uploader.driver');
        $url = Yii::$app->request->post('url');
        if (empty($driver) || strtolower($driver) == 'local') {
            $driver = new LocalDriver();
            return $driver->delete($url);
        } else {
            $class = '\\app\\addons\\' . strtolower($driver) . '\\driver\\Storage';
            if (class_exists($class)) {
                return call_user_func([Yii::createObject($class), 'deleteFile'], $url);
            } else {
                throw new BizException('Uploader driver not exists', 404);
            }
        }
    }
}

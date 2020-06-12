<?php

namespace app\mmadmin\uploader;

use app\mmadmin\core\BizException;
use app\mmadmin\helpers\MAHelper;
use Yii;
use yii\base\Action;

/**
 * 获取驱动的验证token
 */
class TokenAction extends Action
{

    public function run()
    {
        $driver = MAHelper::getSetting('uploader.driver');
        if (empty($driver) || strtolower($driver) == 'local') {
            return time();
        } else {
            $class = '\\app\\addons\\' . strtolower($driver) . '\\driver\\Storage';
            if (class_exists($class)) {
                return call_user_func([Yii::createObject($class), 'generateToken']);
            } else {
                throw new BizException('Uploader driver not exists', 404);
            }
        }
    }
}
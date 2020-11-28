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
        $driver = MAHelper::getSetting('system.storage.driver');
        if (empty($driver) || strtolower($driver) == 'local') {
            return time();
        } else {
            if (class_exists($driver)) {
                return call_user_func([Yii::createObject($driver), 'generateToken']);
            } else {
                throw new BizException('Uploader driver not exists', 404);
            }
        }
    }

    private function generateFileKey(){
        
    }
}

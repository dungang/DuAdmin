<?php
namespace app\kit\components;

use yii\base\Action;
use abei2017\wx\Application;
use app\kit\helpers\KitHelper;

/**
 *
 * @author dungang
 */
class WechatServerAction extends Action
{
    public function run(){
        $app = new Application([
            'conf' => KitHelper::getSettingAssoc('wechat.mp')
        ]);
        $server = $app->driver("mp.server");
        return $server->serve();
    }
}


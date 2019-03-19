<?php
namespace app\kit\components;

use yii\base\BootstrapInterface;

/** 
 * @author dungang
 * 
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * {@inheritDoc}
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        //读取插件脚本下的配置，修改网站默认的配置。
        $scriptDir = \Yii::getAlias('@webroot');
        if (\is_file($scriptDir . '/' . 'config.php')) {
            $config = require $scriptDir . '/' . 'config.php';
            foreach ($config as $attr => $val) {
                $app->{$attr} = $val;
            }
        }
        \Yii::setAlias('@webroot', '@app/public');
        \Yii::setAlias('@web', '/baiyuan-yii2/public');
    }
}


<?php
namespace app\mmadmin\components;

use app\mmadmin\core\Application;
use app\mmadmin\hooks\ViewInitedHook;
use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\BaseFileHelper;
use yii\helpers\Inflector;
use yii\i18n\PhpMessageSource;
use app\mmadmin\helpers\LoaderHelper;

/**
 * 以后这里的配置从其他的外部配置读取
 *
 * @author dungang
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app
     *            the application currently running
     * {@inheritdoc}
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        // 注册MMAdmin的多语言
        $app->i18n->translations['ma'] = [
            'class' => PhpMessageSource::className(),
            'sourceLanguage' => Yii::$app->sourceLanguage,
            'basePath' => '@app/mmadmin/messages'
        ];

        // 更换mysql的schema对象，支持for update 排他锁
        if ($app->db) {
            $app->db->schemaMap['mysql'] = 'app\mmadmin\mysql\Schema';
            $app->db->schemaMap['mysqli'] = 'app\mmadmin\mysql\Schema';
        }
        $this->dynamicParseAddons($app);
    }

    protected function dynamicParseAddons($app)
    {
        $addons = LoaderHelper::dynamicParseAddons();
        if (is_array($addons)) {
            foreach ($addons as $addon) {
                // 1. 注册加载的类库
                LoaderHelper::loadAddonLibs($addon);
                // 2. 设置模块
                $app->setModule($addon['id'], [
                    'class' => $addon['mainClass']
                ]);
                // 3. 其他待定
            }
        }
    }
}

<?php

namespace Backend\Controllers;

use DuAdmin\Components\AddonInstaller;
use DuAdmin\Core\BackendController;
use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use yii\data\ArrayDataProvider;
use DuAdmin\Helpers\LoaderHelper;
use Exception;
use Yii;

/**
 * 插件管理
 * Class AddonController
 * @package Backend\Controllers
 */
class AddonController extends BackendController
{
    public function actionIndex()
    {
        $models = LoaderHelper::dynamicParseAddons();
        $dataProvider = new ArrayDataProvider([
            'models' => $models
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * 开放插件
     * @param $name
     * @return \yii\web\Response
     * @throws BizException
     */
    public function actionOpen($name)
    {
        $dirPath = \Yii::$app->basePath . '/Addons/' . $name;
        if (is_dir($dirPath)) {
            $installed = LoaderHelper::loadInstalledAddonsConfig();
            $installed[] = $name;
            LoaderHelper::saveInstalledAddonsConfig($installed);
            return $this->redirectSuccess(['index'], "开放成功");
        }
        throw new BizException("插件不存在");
    }


    /**
     * 安装插件
     * @param $name
     * @return \yii\web\Response
     * @throws BizException
     */
    public function actionInstall($name)
    {
        $addonInstaller = new AddonInstaller(['addonName' => $name]);
        $addonInstaller->install();
        return $this->redirectSuccess(['index'], "安装成功");
    }

    /**
     * 关闭插件
     * @param $name
     * @return \yii\web\Response
     * @throws BizException
     */
    public function actionClose($name)
    {
        $dirPath = \Yii::$app->basePath . '/Addons/' . $name;
        if (is_dir($dirPath)) {
            $installed = LoaderHelper::loadInstalledAddonsConfig();
            $installed = array_filter($installed, function ($el) use ($name) {
                if ($el == $name) {
                    return false;
                } else {
                    return true;
                }
            });
            return $this->redirectSuccess(['index'], "关闭成功");
        }
        throw new BizException("插件不存在");
    }

    /**
     * 卸载插件
     * @param $name
     * @return \yii\web\Response
     * @throws BizException
     */
    public function actionUninstall($name)
    {
        $addonInstaller = new AddonInstaller(['addonName' => $name]);
        $addonInstaller->uninstall();
        return $this->redirectSuccess(['index'], "卸载成功");
    }
}

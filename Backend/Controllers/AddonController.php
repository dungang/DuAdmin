<?php

namespace Backend\Controllers;

use Backend\Components\AddonInstaller;
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
        $dirPath = \Yii::$app->basePath . '/Addons/' . $name;
        if (is_dir($dirPath)) {
            $installed = LoaderHelper::loadInstalledAddonsConfig();
            $installed[] = $name;
            LoaderHelper::saveInstalledAddonsConfig($installed);
            $addonInstaller = new AddonInstaller(['addonName' => $name]);
            $migrations = $addonInstaller->getAddonMigrations();
            if ($migrations) {
                foreach ($migrations as $migration) {
                    try {
                        $addonInstaller->migrateUp($migration);
                    } catch (Exception $e) {
                        Yii::error($e->getMessage());
                        throw new BizException("安装数据出错:" . $e->getMessage());
                    }
                }
                AppHelper::cleanSettingRelationCache();
            }

            return $this->redirectSuccess(['index'], "安装成功");
        }
        throw new BizException("插件不存在");
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
            LoaderHelper::saveInstalledAddonsConfig($installed);
            $addonInstaller = new AddonInstaller(['addonName' => $name]);
            $migrations = $addonInstaller->getAddonMigrations(false);
            if ($migrations) {
                foreach ($migrations as $migration) {
                    try {
                        $addonInstaller->migrateDown($migration);
                    } catch (Exception $e) {
                        Yii::error($e->getMessage());
                        throw new BizException("卸载数据出错:" . $e->getMessage());
                    }
                }
                AppHelper::cleanSettingRelationCache();
            }
            return $this->redirectSuccess(['index'], "卸载成功");
        }
        throw new BizException("插件不存在");
    }
}

<?php

namespace Console;

use yii\console\Controller;
use yii\helpers\VarDumper;

/**
 * 必须指定插件处于开发模式，Gii才能发现
 */
class GiiDevController extends Controller
{
    /**
     * 指定处于开发模式的插件,
     * 如果没指定参数 则相当于 reset
     */
    public function actionIndex($addonName = null)
    {
        $installedAddonsFile = \Yii::$app->basePath . '/Config/generator.php';
        if ($addonName) {
            file_put_contents($installedAddonsFile, "<?php\nreturn " . VarDumper::export([
                $addonName
            ]) . ";\n");
        } else {
            file_put_contents($installedAddonsFile, "<?php\nreturn " . VarDumper::export([]) . ";\n");
        }
    }

    /**
     * 重置，相当于清楚
     */
    public function actionReset()
    {
        $installedAddonsFile = \Yii::$app->basePath . '/Config/generator.php';
        file_put_contents($installedAddonsFile, "<?php\nreturn " . VarDumper::export([]) . ";\n");
    }
}

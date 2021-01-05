<?php
namespace Console;

use yii\console\Controller;
use yii\helpers\FileHelper;
use yii\helpers\Console;

/**
 * 清理assets
 * @author dunga
 *
 */
class CleanAssetsController extends Controller
{
    /**
     * 清理assets
     */
    public function actionIndex(){
        $dirs = FileHelper::findDirectories(\Yii::$app->basePath . '/public/assets',['recursive'=>false]);
        if($dirs) {
            foreach($dirs as $dir) {
                FileHelper::removeDirectory($dir);
            }
        }
        Console::output(json_encode($dirs));
    }
}


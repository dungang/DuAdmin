<?php
namespace Console;

use Exception;
use Yii;
use yii\console\Controller;

class TestTaskController extends Controller {

    public function actionIndex($class){
        $class = str_replace('.','\\',$class);
        if(class_exists($class)) {
            $instance = Yii::createObject($class);
            $instance->handle('','');
        } else {
            throw new Exception($class . ' not found');
        }
    }
}
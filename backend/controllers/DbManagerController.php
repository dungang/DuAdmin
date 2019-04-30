<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;
use yii\data\ArrayDataProvider;
use app\kit\helpers\MySQLBackupHelpers;

class DbManagerController extends BackendController
{
    public function actionIndex()
    {
        $tables = \Yii::$app->db->createCommand('SHOW TABLE STATUS')->queryAll();
        $dataProvider  = new ArrayDataProvider([
            'key' => 'Name',
            'allModels' => $tables,
            'pagination' => false,
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionBackup()
    {
        $backdir = \Yii::getAlias('@app/backup/');
        $file = MySQLBackupHelpers::generateBackupFile($backdir);
        MySQLBackupHelpers::backup($file);
        if (file_exists($file)) {
            return $this->redirectOnSuccess(['index'], '备份成功');
        } else {
            return $this->redirectOnFail(['index'], '备份失败');
        }
    }
}

<?php
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\Cron */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '定时任务', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加Crons信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>

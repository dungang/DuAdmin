<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\DataCache */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '数据缓存', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加数据缓存信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>

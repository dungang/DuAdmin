<?php
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\Menu */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '菜单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加菜单信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
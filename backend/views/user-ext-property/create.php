<?php
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\UserExtProperty */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '用户扩展属性', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加用户扩展属性信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>

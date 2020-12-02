<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\Portal */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => 'Portals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加Portals信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>

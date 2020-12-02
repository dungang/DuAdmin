<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\SourceMessage */

$this->title = Yii::t('da','Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Update Info'),
    'content'=>$this->render('_form', ['model' => $model])
])?>

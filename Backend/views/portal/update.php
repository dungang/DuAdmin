<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\Portal */

$this->title = Yii::t('da','Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('da_portal', 'Portals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Update Info'),
    'content'=>$this->render('_form', ['model' => $model,'action'=>['update','id'=>$model->id]])
])?>

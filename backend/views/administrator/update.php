<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\Admin */

$this->title = Yii::t('ma','Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Administors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('ma','Update Info'),
    'content'=>$this->render('_form', ['model' => $model])
])?>

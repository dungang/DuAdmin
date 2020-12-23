<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Navigation */

$this->title = Yii::t('da','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Navigations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Create {0} Info',Yii::t('backend', 'Navigations')),
    'content'=>$this->render('_form', ['model' => $model,'action'=>['create']])
])?>

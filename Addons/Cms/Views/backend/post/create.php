<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;


/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Post */
$this->title = Yii::t('da','Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('da_post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Create {0} Info',Yii::t('da_post', 'Posts')),
    'content'=>$this->render('_form', ['model' => $model,'action'=>['create']])
]);
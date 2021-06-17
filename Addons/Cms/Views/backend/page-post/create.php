<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\PagePost */

$this->title = Yii::t('da', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('da_page_post', 'Page Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'Create {0} Info', Yii::t('da_page_post', 'Page Posts')),
    'content' => $this->render('_form', ['model' => $model, 'action' => ['create', 'language' => $model->language]])
]);
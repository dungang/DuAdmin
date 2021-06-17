<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\PagePost */

$this->title = Yii::t('da', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('da_page_post', 'Page Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'pageId' => $model->pageId, 'language' => $model->language]];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'Update Info'),
    'content' => $this->render('_form', ['model' => $model, 'action' => ['update', 'pageId' => $model->pageId, 'language' => $model->language]])
]);
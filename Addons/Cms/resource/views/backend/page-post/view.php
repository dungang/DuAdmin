<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\PagePost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('da_page_post', 'Page Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->title;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->title),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'pageId',
            'language',
            'title',
            'content:ntext',
            'createdAt:date',
            'updatedAt:date',
            ],
        ])
]);
?>

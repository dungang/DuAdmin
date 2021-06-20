<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\PageBlock */
$this->title = $model->name;
$this->params ['breadcrumbs'] [] = [
    'label' => Yii::t( 'app_page_block', 'Page Blocks' ),
    'url' => [
        'index'
    ]
];
$this->params ['breadcrumbs'] [] = $this->title;
$this->params ['breadcrumbs'] [] = $model->name;
echo AjaxModalOrNormalPanelContent::widget( [
    'intro' => Yii::t( 'da', 'View {0} Detail Info', $model->name ),
    'content' => DetailView::widget( [
        'options' => [
            'class' => 'table table-bordered'
        ],
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'widget',
            'sourceApp',
            'createdAt:date',
            'updatedAt:date'
        ]
    ] )
] );
?>
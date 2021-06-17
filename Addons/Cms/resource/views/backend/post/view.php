<?php
use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('da_post', 'Posts'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->title;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info', $model->title),
    'content' => DetailView::widget([
        'options' => [
            'class' => 'table table-bordered'
        ],
        'model' => $model,
        'attributes' => [
            'id',
            'slug',
            'title',
            'admin.name',
            'category.name',
            'cover:image',
            'content:raw',
            'viewTimes',
            'enableComment',
            'keywords',
            'description',
            'createdAt:datetime',
            'updatedAt:datetime',
        ]
    ])
]);
?>

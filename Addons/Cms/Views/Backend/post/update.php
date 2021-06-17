<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model \Addons\Cms\Models\Post */
$categoryName = $model->category->name;
$this->title = Yii::t('da', 'Update {0}', $categoryName);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('da_post', 'Posts'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->title,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'Update {0} Info', $categoryName),
    'content' => $this->render('_form', [
        'model' => $model,
        'action' => [
            'update',
            'id' => $model->id
        ]
    ])
])?>

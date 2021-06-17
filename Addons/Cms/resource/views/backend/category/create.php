<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\Category */

$this->title = Yii::t('da', 'Create');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('da_post_category', 'Post Categories'),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'Create {0} Info', Yii::t('da_post_category', 'Categories')),
    'content' => $this->render('_form', [
        'model' => $model,
        'action' => [
            'create'
        ]
    ])
])?>

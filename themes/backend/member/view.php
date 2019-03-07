<?php
use yii\widgets\DetailView;
use app\kit\widgets\AjaxModalOrNormalPanelContent;
/* @var $this yii\web\View */
/* @var $model app\kit\models\User */

$this->title = '查看用户';
$this->params['breadcrumbs'][] = [
    'label' => '用户',
    'url' => [
        'index'
    ]
];

$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->username;

echo AjaxModalOrNormalPanelContent::widget([
    'title' => $this->title,
    'summary' => $model->username,
    'content' => DetailView::widget([
        'options'=>['class' => 'table table-bordered'],
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'nick_name',
            'email:email',
            'mobile',
            'is_admin',
            'is_super',
            'role',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model['status'] == 10) {
                        return "激活";
                    } else {
                        return "未激活";
                    }
                }
            ],
            'created_at:date',
            'updated_at:date'
        ]
    ])
])?>

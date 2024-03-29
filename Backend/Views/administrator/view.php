<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model Backend\Models\Admin */
$this->title = $model->username;
$this->params ['breadcrumbs'] [] = [
    'label' => Yii::t( 'app_admin', 'Admins' ),
    'url' => [
        'index'
    ]
];
$this->params ['breadcrumbs'] [] = $this->title;
$this->params ['breadcrumbs'] [] = $model->id;
echo AjaxModalOrNormalPanelContent::widget( [
    'intro' => Yii::t( 'da', 'View {0} Detail Info', $model->username ),
    'content' => DetailView::widget( [
        'options' => [
            'class' => 'table table-bordered'
        ],
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'nickname',
            'avatar',
            'email:email',
            'mobile',
            'status:datetime',
            'isSuper',
            'loginAt',
            'loginFailure',
            'loginIp',
            'createdAt',
            'updatedAt'
        ]
    ] )
] );
?>

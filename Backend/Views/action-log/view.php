<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model Backend\Models\ActionLog */
$this->title = $model->action;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t( 'app_action_log', 'Action Logs' ),
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->action;
echo AjaxModalOrNormalPanelContent::widget( [
    'intro' => Yii::t( 'da', 'View {0} Detail Info', $model->action ),
    'content' => DetailView::widget( [
        'options' => [
            'class' => 'table table-bordered'
        ],
        'model' => $model,
        'attributes' => [
            'id',
            'admin.username',
            'action',
            'ip',
            'method',
            'sourceType',
            'createdAt',
            'data:ntext'
        ]
    ] )
] );
?>

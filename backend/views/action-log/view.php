<?php

use yii\widgets\DetailView;
use app\kit\widgets\AjaxModalOrNormalPanelContent;
use app\kit\models\User;

/* @var $this yii\web\View */
/* @var $model app\kit\models\ActionLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Action Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->id;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：' . $model->id,
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
            [
                'attribute'=>'user_id',
                'value'=>function($model){
                    if($user = User::findOne(['id'=>$model->user_id])) {
                        return $user->nick_name;
                    }
                    return '';
                }
            ],
            'action',
            'created_at:datetime',
            'data:ntext',
            ],
        ])
]);

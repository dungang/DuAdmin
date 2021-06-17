<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\FriendLink */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('da_friend_link', 'Friend Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->name),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'name',
            'pid',
            'url:url',
            'sort',
            'createdAt:date',
            'updatedAt:date',
            ],
        ])
]);
?>

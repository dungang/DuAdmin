<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\AuthPermission */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app_auth_item', 'Auth Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => Yii::t('da', 'View {0} Detail Info',$model->name),
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'type',
            'name',
            'ruleId',
            'data',
            'createdAt:date',
            'updatedAt:date',
            ],
        ])
]);
?>

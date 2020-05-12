<?php

use yii\widgets\DetailView;
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\UserExtProperty */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '用户扩展属性', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：' . $model->name,
    'content' => DetailView::widget([
        	'options'=>['class' => 'table table-bordered'],
            'model' => $model,
            'attributes' => [
                'id',
            'field',
            'name',
            'data_type',
            'data_length',
            'hint',
            'is_required:boolean',
            'input_type',
            'input_value:ntext',
            'sort',
            ],
        ])
]);
?>

<?php

use app\mmadmin\widgets\DetailView;
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\Menu */

$this->title = '查看';
$this->params['breadcrumbs'][] = ['label' => '菜单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：'  . $model->name,
    'content' => DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'is_front:boolean',
            'pid',
            'icon',
            'sort',
        ],
    ])
])?>
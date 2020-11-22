<?php

use app\backend\models\Admin;
use app\mmadmin\grids\PanelGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\mmadmin\models\ActionLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '操作日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'action-log-index']); ?>
<?php  PanelGridView::begin([
    	'intro' => '操作日志信息管理',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'created_at:datetime',
            [
                'class'=>'app\mmadmin\grids\FilterColumn',
                'attribute'=>'user_id',
                'filter'=> Admin::allIdToName('id','nickname'),
            ],
            [
                'class'=>'app\mmadmin\grids\FilterColumn',
                'attribute'=>'method',
                'filter'=> [
                    'POST'=>'POST',
                    'GET'=>'GET',
                    'PUT'=>'PUT',
                    'OPTION'=>'OPTION',
                    'HEAD'=>'HEAD'
                ]
            ],
            'action',
            [
                'attribute'=>'ip',
                'value'=>function($model){
                    return long2ip($model->ip);
                }
            ],
            [
                'class' => '\app\mmadmin\grids\ActionColumn',
                'template'=>'{view}',
                'buttonsOptions'=>[
                    'view'=>[
                        'data-toggle'=>'modal',
                        'data-target'=>'#modal-dailog',
                    ],
                ]
        	]
       ]
    ]); ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


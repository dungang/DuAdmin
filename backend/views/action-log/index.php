<?php

use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\ActionLogSearch */
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
            [
                'class'=>'app\kit\grids\FilterColumn',
                'attribute'=>'user_id',
                'filter'=> User::allIdToName('id','nick_name'),
            ],
            [
                'class'=>'app\kit\grids\FilterColumn',
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
            'created_at:datetime',
            [
                'class' => '\app\kit\grids\ActionColumn',
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


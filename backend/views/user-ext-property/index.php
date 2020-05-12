<?php

use yii\helpers\Html;
use app\mmadmin\grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\mmadmin\models\UserExtPropertySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户扩展属性';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'user-ext-property-index']); ?>
<?php  PanelGridView::begin([
    	'intro' => '用户扩展属性信息管理',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return Html::a($model['name'],['view','id'=>$model['id']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],
            'field',
            'data_type',
            'is_required:boolean',
            'input_type',
            'sort',
            [
                'class' => '\app\mmadmin\grids\ActionColumn',
                'buttonsOptions'=>[
                    'update'=>[
                        'data-toggle'=>'modal',
                        'data-target'=>'#modal-dailog',
                    ],
                    'view'=>[
                        'data-toggle'=>'modal',
                        'data-target'=>'#modal-dailog',
                    ],
                ]
        	]
       ]
    ]); ?>
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class'=>'btn btn-sm btn-link','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


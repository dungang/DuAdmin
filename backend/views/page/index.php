<?php

use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\grids\PanelTreeGridView;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '单页';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php  PanelTreeGridView::begin([
    	'intro' => '单页信息管理',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return Html::a($model['title'],['view','id'=>$model['id']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],
            'slug',
            'sort',
            [
                'class' => '\app\kit\grids\ActionColumn',
        	]
       ]
    ]); ?>
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class'=>'btn btn-sm btn-link','data-pjax'=>'0']) ?>
<?php PanelTreeGridView::end() ?>


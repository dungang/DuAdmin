<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\backend\models\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Portals';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'portal-index']); ?>
<?php  PanelGridView::begin([
    	'intro' => 'Portals信息管理',
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
            'source',
            'is_static:boolean',
            'unlimited:boolean',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
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
<?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>

<?=DuAdmin\Widgets\FullSearchBox::widget(['action'=>['index']]) ?>

<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


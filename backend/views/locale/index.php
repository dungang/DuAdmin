<?php

use yii\helpers\Html;
use app\mmadmin\grids\PanelGridView;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\backend\models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Locale');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'locale-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'locale-list',
    	'intro' => Yii::t('ma','{0} Info Manage',Yii::t('app', 'Source Messages')),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class'=>'\yii\grid\CheckboxColumn','options'=>['width'=>'50px']],
            [
                'attribute' => 'category',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return Html::a($model['category'],['view','id'=>$model['id']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],
            'message:ntext',
            [
                'label'=>Yii::t('ma','Operation'),
                'format'=>'raw',
                'value' => function($model,$key,$index,$column) {
                    return Html::a(Yii::t('ma','Manage {0}', Yii::t('app','Messages')),['/message/index','MessageSearch[id]'=>$model->id],
                    ['class'=>'btn btn-sm btn-link','data-pjax'=>'0']);
                }
            ],
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
<?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('ma','Create'), ['create'], ['class'=>'btn btn-sm btn-link','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('ma','Delete'), ['delete'], ['class'=>'btn btn-sm btn-link del-all','data-target'=>'#source-message-list']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


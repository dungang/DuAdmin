<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;

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
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('app', 'Source Messages')),
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
                'label'=>Yii::t('da','Operation'),
                'format'=>'raw',
                'value' => function($model,$key,$index,$column) {
                    return Html::a(Yii::t('da','Manage {0}', Yii::t('app','Messages')),['/message/index','MessageSearch[id]'=>$model->id],
                    ['class'=>'btn btn-sm btn-link','data-pjax'=>'0']);
                }
            ],
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

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#locale-list']) ?>

<?=DuAdmin\Widgets\FullSearchBox::widget(['action'=>['index']]) ?>

<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


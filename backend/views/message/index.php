<?php

use yii\helpers\Html;
use app\mmadmin\grids\PanelGridView;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\backend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'message-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'message-list',
    	'intro' => Yii::t('ma','{0} Info Manage','Messages'),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return Html::a($model['id'],['view','id'=>$model['id']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],
            'language',
            'translation:ntext',
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
<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('ma','Delete'), ['delete'], ['class'=>'btn btn-sm btn-link del-all','data-target'=>'#message-list']) ?>
<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


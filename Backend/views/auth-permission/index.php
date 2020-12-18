<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\AuthPermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Auth Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'auth-permission-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'auth-permission-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Auth Permissions')),
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=>'\yii\grid\CheckboxColumn','name'=>'id'],
            [
                'attribute' => 'id',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return AppHelper::linkButtonWithSimpleModal($model['id'],['view','id'=>$model['id']]);
                }
        	],
            'type',
            'name',
            'ruleId',
            'data',
            //'createdAt:date',
            //'updatedAt:date',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
        	]
       ]
    ]); ?>

<?= FullSearchBox::widget(['action'=>['index']]) ?> 

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= AppHelper::linkButtonWithBigSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Batch Create'), ['batch-create'], ['class'=>'btn btn-primary', ]) ?>

<?= Html::a('<i class="fa fa-edit"></i> ' . Yii::t('da','Batch Update'), ['#'], [
        'data-url' => Url::to(['batch-update']),
        'class'=>'btn btn-success batch-update','data-modal-size' => 'modal-lg','data-target'=>'#auth-permission-list']) ?>

<?= Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#auth-permission-list']) ?>
<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


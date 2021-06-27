<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel DuAdmin\Models\GenTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_gen_table', 'Gen Tables');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'gen-table-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'gen-table-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('app_gen_table', 'Gen Tables')),
        'dataProvider' => $dataProvider,
        'columns' => [
                            ['class'=>'\DuAdmin\Grids\CheckboxColumn','name'=>'id'],
                            [
                                'attribute' => 'id',
                                'format'=>'raw',
                                'value'=>function($model,$key,$index,$column){
                                    return AppHelper::linkButtonWithSimpleModal($model['id'],['view','id'=>$model['id']]);
                                }
                        	],
            'tableName',
            'tableComment',
            'modelNamespace',
            'modelName',
            //'modelBaseName',
            //'activeQueryBaseName',
            //'dbConnectionId',
            //'enableSearchModel',
            //'enableI18n',
            //'backendControllerNamespace',
            //'frontendControllerNamespace',
            //'apiControllerNamespace',
            //'backendControllerBase',
            //'frontendControllerBase',
            //'apiControllerBase',
            //'controllerName',
            //'backendViewPath',
            //'frontendViewPath',
            //'backendListView',
            //'frontendistView',
            //'backendActions',
            //'frontendActions',
            //'modalDailogSize',
            //'enableUserData',
            //'enablePjax',
            //'createdAt:date',
            //'updatedAt:date',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
                'modalSize' => 'modal-lg',
                'template' => '{view} {update} {delete}',
        	]
       ]
    ]); ?>

<?= FullSearchBox::widget(['action'=>['index']]) ?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithBigSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>
<?= Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#gen-table-list']) ?>
<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


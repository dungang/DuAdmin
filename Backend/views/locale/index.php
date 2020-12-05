<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\SourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Source Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'source-message-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'source-message-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Source Messages')),
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=>'\yii\grid\CheckboxColumn'],
            [
                'attribute' => 'id',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return AppHelper::linkButtonWithSimpleModal($model['id'],['view','id'=>$model['id']]);
                }
        	],
            'category',
            'message:ntext',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
        	]
       ]
    ]); ?>
<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#source-message-list']) ?>

<?= FullSearchBox::widget(['action'=>['index']]) ?> 

<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


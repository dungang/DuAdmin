<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Auth Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'auth-rule-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'auth-rule-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Auth Rules')),
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=>'\yii\grid\CheckboxColumn','name'=>'id'],
            [
                'attribute' => 'name',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return AppHelper::linkButtonWithSimpleModal($model['name'],['view','id'=>$model['id']]);
                }
        	],
            'id',
            'data',
            'createdAt:date',
            'updatedAt:date',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
        	]
       ]
    ]); ?>

<?= FullSearchBox::widget(['action'=>['index']]) ?> 

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#auth-rule-list']) ?>
<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


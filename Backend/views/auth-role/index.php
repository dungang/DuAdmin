<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\AuthRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Auth Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'auth-role-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'auth-role-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Auth Roles')),
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=>'\DuAdmin\Grids\CheckboxColumn','name'=>'id'],
            [
                'attribute' => 'name',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return AppHelper::linkButtonWithSimpleModal($model['name'],['view','id'=>$model['id']]);
                }
        	],
            'id',
            [
                'label' => Yii::t('backend','Assignment'),
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Yii::t('backend','assignment'), [
                        'permission',
                        'id' => $model['id'],
                    ]);
                }
            ],
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

<?= Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#auth-role-list']) ?>
<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


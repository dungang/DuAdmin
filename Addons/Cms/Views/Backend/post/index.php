<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Addons\Cms\Models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('da_post', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'post-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'post-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('da_post', 'Posts')),
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=>'\yii\grid\CheckboxColumn'],
            [
                'attribute' => 'title',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return AppHelper::linkButtonWithSimpleModal($model['title'],['view','id'=>$model['id']]);
                }
        	],
            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    return Html::img($model->cover, ['width' => '100']);
                }
            ],
            'admin.nickname',
            'category.name',
            'viewTimes',
            [  
                'class' => 'DuAdmin\Grids\DateTimeColumn',
                'attribute' => 'createdAt',
            ],
            [  
                'class' => 'DuAdmin\Grids\DateTimeColumn',
                'attribute' => 'updatedAt',
            ],
            'isPublished:boolean',
            //'cover:image',
            //'keywords',
            //'description',
            //'content:ntext',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
                'modalSize' => 'modal-lg'
        	]
       ]
    ]); ?>
<?= FullSearchBox::widget(['action'=>['index']]) ?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithBigSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#post-list']) ?>

<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


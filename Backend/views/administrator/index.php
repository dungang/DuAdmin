<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Admins');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'admin-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'admin-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Admins')),
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
            'username',
            'nickname',
            'avatar',
            'authKey',
            //'passwordHash',
            //'passwordResetToken',
            //'email:email',
            //'mobile',
            //'status:datetime',
            //'isSuper',
            [  
                'class' => 'DuAdmin\Grids\DateTimeColumn',
                'attribute' => 'loginAt',
            ],
            //'loginFailure',
            //'loginIp',
            [  
                'class' => 'DuAdmin\Grids\DateTimeColumn',
                'attribute' => 'createdAt',
            ],
            [  
                'class' => 'DuAdmin\Grids\DateTimeColumn',
                'attribute' => 'updatedAt',
            ],
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
        	]
       ]
    ]); ?>
<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#admin-list']) ?>

<?= FullSearchBox::widget(['action'=>['index']]) ?> 

<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


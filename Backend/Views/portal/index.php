<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_portal', 'Portals');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'portal-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'portal-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('app_portal', 'Portals')),
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
            'name',
            'code',
            'source',
            'isStatic',
            //'unlimited',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
                'modalSize' => '',
                'template' => '{view} {update} {delete}',
        	]
       ]
    ]); ?>

<?= FullSearchBox::widget(['action'=>['index']]) ?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>
<?= Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#portal-list']) ?>
<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>

<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Addons\ChinaRegion\Models\ChinaRegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('addon_china_region', 'China Regions');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'china-region-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'china-region-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('addon_china_region', 'China Regions')),
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
            'pid',
            'level',
            'name',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
        	]
       ]
    ]); ?>
<?= FullSearchBox::widget(['action'=>['index']]) ?>

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#china-region-list']) ?>

<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


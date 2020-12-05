<?php

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\ActionLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Action Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'action-log-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'action-log-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Action Logs')),
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
            'userId',
            'action',
            'ip',
            'method',
            //'sourceType',
            [  
                'class' => 'DuAdmin\Grids\DateTimeColumn',
                'attribute' => 'createdAt',
            ],
            //'data:ntext',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
				'template' => '{view}',
        	]
       ]
    ]); ?>
<?= $this->render('_search', ['model' => $searchModel]); ?>


<?= FullSearchBox::widget(['action'=>['index']]) ?> 

<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\backend\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Administors');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'admin-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'admin-list',
    	'intro' => Yii::t('da','{0} Info Manage',Yii::t('backend', 'Admins')),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'username',
                'format'=>'raw',
                'value'=>function($model,$key,$index,$column){
                    return Html::a($model['username'],['view','id'=>$model['id']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],
            'nickname',
            'status',
            'login_failure',
            'login_at:datetime',
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
                'buttonsOptions'=>[
                    'update'=>[
                        'data-toggle'=>'modal',
                        'data-target'=>'#modal-dailog',
                    ],
                    'view'=>[
                        'data-toggle'=>'modal',
                        'data-target'=>'#modal-dailog',
                    ],
                ]
        	]
       ]
    ]); ?>
<?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>

<?=DuAdmin\Widgets\FullSearchBox::widget(['action'=>['index']]) ?>

<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


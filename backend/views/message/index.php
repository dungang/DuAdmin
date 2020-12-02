<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\backend\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id'=>'message-index']); ?>
<?php  PanelGridView::begin([
        'id' => 'message-list',
    	'intro' => Yii::t('da','{0} Info Manage','Messages'),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'language',
            'translation:ntext',
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


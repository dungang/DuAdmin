<?php
use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\backend\models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '验证规则';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin(['id'=>'rule-index']);
PanelGridView::begin([
    'intro'=>'验证规则，不是表单验证，而是权限标识的增强，在验证某个权限标识的时候需要验证<strong>某些条件</strong>（可以理解为验证规则）。',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        'name',
        [
            'class' => 'DuAdmin\Grids\ActionColumn',
            'buttonsOptions' => [
                'update' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ],
                'view' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ]
            ]
        ]
    ]
]);
?>
<?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('ma','Create'), ['create'], ['class'=>'btn btn-primary','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>

<?=DuAdmin\Widgets\FullSearchBox::widget(['action'=>['index']]) ?>
<?php PanelGridView::end()?>
<?php Pjax::end()?>

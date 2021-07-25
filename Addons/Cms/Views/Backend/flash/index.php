<?php

use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
use yii\widgets\Pjax;
use DuAdmin\Widgets\FullSearchBox;
use DuAdmin\Helpers\AppHelper;
/* @var $this yii\web\View */
/* @var $searchModel Addons\Cms\Models\FlashSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =  Yii::t('da_flash', 'Flashes');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'fe-flash-index']); ?>
<?php PanelGridView::begin([
    'id' => 'flash-list',
    'intro' =>  Yii::t('da', 'Manage {0}', $this->title),
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => '\yii\grid\CheckboxColumn'],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::a($model['name'], ['view', 'id' => $model['id']], ['data-toggle' => 'modal', 'data-target' => '#modal-dialog']);
            }
        ],
        [
            'attribute' => 'pic',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return Html::img($model->pic, ['width' => '100']);
            }
        ],
        'bgColor',
        'url:url',
        'sort',
        //'createdAt:datetime',
        //'updatedAt:datetime',
        [
            'class' => '\DuAdmin\Grids\ActionColumn',
            'buttonsOptions' => [
                'update' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dialog',
                ],
                'view' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dialog',
                ],
            ]
        ]
    ]
]); ?>
<?= FullSearchBox::widget(['action' => ['index']]) ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('da', 'Delete'), ['delete'], ['class' => 'btn btn-danger del-all', 'data-target' => '#category-list']) ?>

<?php PanelGridView::end() ?>
<?php Pjax::end(); ?>


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
<?php

PanelGridView::begin([
    'id' => 'admin-list',
    'intro' => Yii::t('da', '{0} Info Manage', Yii::t('backend', 'Admins')),
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => '\yii\grid\CheckboxColumn'
        ],
        [
            'attribute' => 'id',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                return AppHelper::linkButtonWithSimpleModal($model['id'], [
                    'view',
                    'id' => $model['id']
                ]);
            }
        ],
        'username',
        'nickname',
        'avatar',
        [
            'label' => Yii::t('backend', 'Roles'),
            'format' => 'raw',
            'value' => function ($model, $key, $index) {
                $names = [];
                if ($model->isSuper) {
                    $names[] = '<span class="label label-danger">' . Yii::t('backend', 'Is Super') . '</span>';
                }
                foreach ($model->roles as $role) {
                    $names[] = '<span class="label label-success">' . $role->name . '</span>';
                }
                return implode(',', $names);
            }
        ],
        'email:email',
        'mobile',
        'status',
        [
            'class' => 'DuAdmin\Grids\DateTimeColumn',
            'attribute' => 'loginAt'
        ],
        [
            'class' => 'DuAdmin\Grids\DateTimeColumn',
            'attribute' => 'createdAt'
        ],
        [
            'class' => '\DuAdmin\Grids\ActionColumn',
            'template' => '{view} {update} {roles} {delete}',
            'buttons' => [
                'roles' => function ($url, $model, $key) {
                    return AppHelper::linkButtonWithSmallSimpleModal('<i class="fa fa-user"></i> ' . Yii::t('backend', 'Setting Roles'), [
                        'roles',
                        'userId' => $model->id
                    ]);
                }
            ]
        ]
    ]
]);
?>

<?= FullSearchBox::widget(['action'=>['index']]) ?> 

<?= $this->render('_search', ['model' => $searchModel]); ?>

<?= AppHelper::linkButtonWithSimpleModal('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>

<?= Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#admin-list']) ?>

<?php PanelGridView::end() ?>

<?php Pjax::end(); ?>


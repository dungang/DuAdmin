<?php
use yii\helpers\Html;
use DuAdmin\Grids\PanelGridView;
/* @var $this yii\web\View */
/* @var $searchModel Backend\Models\PortalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('da', 'Addons');
$this->params['breadcrumbs'][] = $this->title;

echo PanelGridView::widget([
    'intro' => 'Addons 信息管理',
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'name',
        'author',
        'type',
        'intro',
        'hasFrontend',
        'hasBackend',
        'hasApi',
        'hasConsole',
        [
            'attribute' => 'hasSetting',
            'format' => 'raw',
            'value' => function ($model, $key, $index) {
                if (isset($model['hasSetting']) && $model['hasSetting']) {
                    return Html::a('<i class="fa fa-cogs"></i> ' . Yii::t('da', 'Setting'), [
                        '/' . $model['id'] . '/setting'
                    ]);
                }
                return '';
            }
        ]
    ]
]);


<?php

use DuAdmin\Grids\PanelGridView;
use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('da', 'Addons');
$this->params['breadcrumbs'][] = $this->title;
echo PanelGridView::widget([
    'intro'        => 'Addons 信息管理',
    'dataProvider' => $dataProvider,
    'columns'      => [
        'id',
        'name',
        'author',
        'type',
        'intro',
        [
            'attribute' => 'active',
            'label' => '状态',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['active']) {
                    return AppHelper::linkButton('<i class="fa fa-check-circle"></i> 开放', ['close', 'name' => $model['name']], ['class' => 'text-success']);
                } else {
                    return AppHelper::linkButton('<i class="fa fa-window-close"></i> 关闭', ['open', 'name' => $model['name']], ['class' => 'text-danger']);
                }
            }
        ],
        //        'hasFrontend',
        //        'hasBackend',
        //        'hasApi',
        //        'hasConsole',
        [
            'attribute' => 'hasSetting',
            'format'    => 'raw',
            'value'     => function ($model, $key, $index) {
                if (isset($model['hasSetting']) && $model['hasSetting']) {
                    return Html::a('<i class="fa fa-cogs"></i> ' . Yii::t('da', 'Setting'), [
                        '/' . $model['id'] . '/setting'
                    ]);
                }
                return '';
            }
        ],
        [
            'attribute' => '安装',
            'format'    => 'raw',
            'value'     => function ($model, $key, $index) {
                $textClass = "text-danger";
                $textAction = "Install";
                $action = 'install';
                if ($model['active']) {
                    $textAction = 'Uninstall';
                    $textClass = 'text-success';
                    $action = 'uninstall';
                }
                return Html::a('<i class="fa fa-cogs"></i> ' . Yii::t('da', $textAction), [
                    $action, 'name' => $model['addon']
                ], ['class' => $textClass]);
            }
        ]
    ]
]);

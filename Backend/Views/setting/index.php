<?php

use DuAdmin\Grids\PanelGridView;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Models\DictData;
use DuAdmin\Models\SettingSearch;
use DuAdmin\Widgets\PanelNavTabs;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel SettingSearch */
/* @var $dataProvider ActiveDataProvider */
$this->title =  Yii::t( 'da', 'Settings' );
$this->params[ 'breadcrumbs' ][] = $this->title;
Pjax::begin( [
    'id' => 'setting-index'
] );
PanelGridView::begin( [
    'intro'        => '设置功能提高了系统的适应性，根据不同的场景和环境配置不同的变量值。',
    'dataProvider' => $dataProvider,
    'summary'      => false,
    'columns'      => [
        [
            'attribute'     => 'title',
            'headerOptions' => [
                'width' => '200px'
            ],
            'format'        => 'raw',
            'value'         => function ( $model, $key, $index, $column ) {
                return $model[ 'title' ] . ' <i class="fa fa-question-circle-o" title="' . $model[ 'hint' ] . '" data-toggle="tooltip" data-placement="top" ></i>';
            }
        ],
        [
            'attribute' => 'value',
            'format'    => 'raw',
            'value'     => function ( $model, $key, $index, $column ) {
                $detail = AppHelper::linkButtonWithSimpleModal( Yii::t( 'da', 'View Detail' ), [
                        'view',
                        'name' => $model[ 'name' ]
                    ] );
                return $model[ 'valType' ] === 'STR' ? (strlen( $model[ 'value' ] ) < 128 ? $model[ 'value' ] : $detail) : $detail;
            }
        ],
        [
            'class'    => '\DuAdmin\Grids\ActionColumn',
            'template' => '{view} {update}'
        ]
    ]
] );
if ( Yii::$app->controller->categoryDict ) {
    $tabs = [];
    $categories = DictData::getDataList( Yii::$app->controller->categoryDict );
    foreach ( $categories as $category ) {
        $tabs[] = [
            'name' => $category->dictLabel,
            'url'  => [
                '/'.Yii::$app->controller->uniqueId,
                'subCategory' => $category->dictValue
            ]
        ];
    }
    echo PanelNavTabs::widget( [
        'wrapper' => true,
        'tabs'    => $tabs
    ] );
}
PanelGridView::end();
Pjax::end();

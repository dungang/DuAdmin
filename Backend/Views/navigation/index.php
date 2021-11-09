<?php
use DuAdmin\Models\Navigation;
use DuAdmin\UI\Box;
use DuAdmin\UI\Column;
use DuAdmin\UI\Row;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\Widgets\TreeSortableList;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $models DuAdmin\Models\Navigation[] */
/* @var $model DuAdmin\Models\Navigation */
/* @var $app string */
$this->title = Yii::t( 'app_navigation', 'Navigations' );
$this->params ['breadcrumbs'] [] = $this->title;
Pjax::begin( [
    'id' => 'navigation-index'
] );
echo AdminltePanel::widget( [
    'id' => 'navigation-list',
    'intro' => Yii::t( 'da', '{0} Info Manage', Yii::t( 'app_navigation', 'Navigations' ) ),
    'content' => Row::widget( [
        'children' => [
            Column::widget( [
                'size' => 8,
                'children' => [
                    TreeSortableList::widget( [
                        'items' => $models,
                        'rowRender' => function ( $item ) {
                          $content = '<i class="' . $item ['icon'] . '"></i> ' . $item ['name'];
                          if ( ($item ['requireAuth']) ) {
                            $content .= ' <span class="label label-danger label-xs">登录可见</span>';
                          }
                          return $content;
                        }
                    ] )
                ]
            ] ),
            Column::widget( [
                'size' => 4,
                'children' => [
                    Box::widget( [
                        'class' => 'box backend-radius',
                        'enableAjaxForm' => true,
                        'children' => [
                            $this->render( '_form', [
                                'model' => new Navigation( [
                                    'app' => $app
                                ] ),
                                'action' => [
                                    'create'
                                ]
                            ] )
                        ]
                    ] )
                ]
            ] )
        ]
    ] )
] );
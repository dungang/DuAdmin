<?php
use DuAdmin\Models\Menu;
use DuAdmin\UI\Box;
use DuAdmin\UI\Column;
use DuAdmin\UI\Row;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\Widgets\TreeSortableList;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $models DuAdmin\Models\Menu[] */
/* @var $model DuAdmin\Models\Menu */
$this->title = Yii::t( 'app_menu', 'Menus' );
$this->params ['breadcrumbs'] [] = $this->title;
Pjax::begin( [
    'id' => 'tree-sort-menu'
] );
AdminltePanel::begin( [
    'intro' => '维护导航菜单，分前后端的菜单，目前只支持2级菜单。',
    'content' => Row::widget( [
        'children' => [
            Column::widget( [
                'size' => 8,
                'children' => [
                    TreeSortableList::widget( [
                        'items' => $models,
                        'rowRender' => function ( $item ) {
                          $content = '<i class="' . $item ['icon'] . '"></i> ' . $item ['name'];
                          if ( empty( $item ['requireAuth'] ) ) {
                            $content .= ' <span class="label label-danger label-xs">不用鉴权</span>';
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
                                'model' => new Menu(),
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
AdminltePanel::end();
Pjax::end()?>
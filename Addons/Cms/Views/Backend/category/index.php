<?php
use Addons\Cms\Models\Category;
use DuAdmin\UI\Box;
use DuAdmin\UI\Column;
use DuAdmin\UI\Row;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\Widgets\TreeSortableList;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $models Addons\Cms\Models\Category[] */
/* @var $model Addons\Cms\Models\Category */
$this->title = Yii::t( 'da_post_category', 'Post Categories' );
$this->params ['breadcrumbs'] [] = $this->title;
?>
<?php
Pjax::begin( [
    'id' => 'category-index'
] );
echo AdminltePanel::widget( [
    'intro' => '分类管理',
    'content' => Row::widget( [
        'children' => [
            Column::widget( [
                'size' => 8,
                'children' => [
                    TreeSortableList::widget( [
                        'items' => $models,
                        'rowRender' => function ( $item ) {
                          return $item ['name'];
                        }
                    ] )
                ]
            ] ),
            Column::widget( [
                'size' => 4,
                'children' => [
                    Box::widget( [
                        'enableAjaxForm' => true,
                        'children' => [
                            $this->render( '_form', [
                                'model' => new Category(),
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
Pjax::end();
?>


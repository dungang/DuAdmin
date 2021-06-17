<?php
use Addons\Cms\Models\FriendLink;
use DuAdmin\UI\Box;
use DuAdmin\UI\Column;
use DuAdmin\UI\Row;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\Widgets\TreeSortableList;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel Addons\Cms\Models\FriendLinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t( 'da_friend_link', 'Friend Links' );
$this->params ['breadcrumbs'] [] = $this->title;
?>
<?php

Pjax::begin( [
    'id' => 'friend-link-index'
] );
?>
<?php
echo AdminltePanel::widget( [
    'intro' => '链接管理',
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
                                'model' => new FriendLink(),
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
?>

<?php

Pjax::end();
?>
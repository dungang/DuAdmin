<?php
use Backend\Models\AuthPermission;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\UI\Box;
use DuAdmin\UI\Column;
use DuAdmin\UI\Row;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\Widgets\TreeSortableList;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $models \Backend\Models\AuthPermission[] */
/* @var $model \Backend\Models\AuthPermission */
$this->title = Yii::t( 'app_auth_item', 'Auth Permissions' );
$this->params ['breadcrumbs'] [] = $this->title;
Pjax::begin( [
    'id' => 'auth-permission-index'
] );
AdminltePanel::begin( [
    'id' => 'auth-permission-tree',
    'intro' => Yii::t( 'da', '{0} Info Manage', Yii::t( 'app_auth_item', 'Auth Permissions' ) ),
    'content' => Row::widget( [
        'children' => [
            Column::widget( [
                'size' => 8,
                'children' => [
                    TreeSortableList::widget( [
                        'maxDepth' => 4, // 1插件（Menu）/2控制器（Manage）/3行为（update）/4同权限行为（sorts）
                        'items' => $models,
                        'rowRender' => function ( $item ) {
                          $content = $item ['name'];
                          return $content;
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
                                'model' => new AuthPermission(),
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
<?=AppHelper::linkButtonWithSimpleModal( '<i class="fa fa-plus"></i> ' . Yii::t( 'da', 'Create' ), [ 'create'], [ 'class' => 'btn btn-primary'] )?>

<?=Html::a( '<i class="fa fa-refresh"></i> ' . Yii::t( 'da', 'Refresh' ), [ 'index'], [ 'class' => 'btn btn-info'] )?>

<?php
AdminltePanel::end();
Pjax::end()?>
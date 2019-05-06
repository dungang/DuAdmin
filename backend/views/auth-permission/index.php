<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
use app\kit\widgets\PanelNavTabs;

/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\AuthPermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin(['id'=>'permission-index']);
PanelGridView::begin([
    'intro'=>'权限标识。用户访问资源的时候实际就是路由的时候，系统会根据<strong>路由寻址到对应的权限标识</strong>，最后根据权限标识找到对应的角色，如果用户拥有该角色则表示可以访问改资源。',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        'name',
        'description:ntext',
        'rule_name',
        [
            'class'=>'app\kit\grids\FilterColumn',
            'attribute' => 'group_name',
            'filter' => $this->params['groups'],
        ],
        [
            'class' => 'app\kit\grids\ActionColumn',
            'buttonsOptions' => [
                'update' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ],
                'view' => [
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-dailog'
                ]
            ]
        ]
    ]
]);

echo PanelNavTabs::widget([
    'wrapper'=>true,
    'tabs' => [
        [
            'name'=>'全部',
            'url' => ['index','is_backend'=>-1]
        ],
        [
            'name'=>'后台',
            'url' => ['index','is_backend'=>1]
        ],
        [
            'name'=>'前台',
            'url' => ['index','is_backend'=>0]
        ],
        [
            'name'=>'<i class="fa fa-plus"></i> 添加',
            'url' => ['create','AuthPermission[group_name]'=>$searchModel->group_name],
            'options'=>['data-toggle'=>'modal','data-target'=>'#modal-dailog']
        ],
    ]
]);
?>
<?php PanelGridView::end()?>
<?php Pjax::end()?>

<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\AcRouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '路由';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin(['id'=>'route-index']);
PanelGridView::begin([
    'intro'=>'路由是指的系统可以访问的资源（空制器和执行动作）。配合授权标识使用，一般一个授权标识对应一个或者多个路由资源。',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        'name',
        'description:ntext',
        'created_at:date',
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
?>
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class' => 'btn btn-sm btn-default','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end()?>
<?php Pjax::end()?>

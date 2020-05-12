<?php
use yii\helpers\Html;
use app\mmadmin\grids\PanelGridView;
use yii\widgets\Pjax;
use app\mmadmin\models\AuthItem;

/* @var $this yii\web\View */
/* @var $searchModel app\mmadmin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin(['id'=>'user-index','formSelector'=>false]);
PanelGridView::begin([
    'intro'=>'管理员信息维护。根据是否是管理者区分是<strong>后台管理员</strong>或者是<strong>前台会员</strong>',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'username',
            'headerOptions' => [
                'width' => '100px'
            ]
        ],
        [
            'attribute' => 'nick_name',
            'headerOptions' => [
                'width' => '100px'
            ]
        ],
        [
            'attribute' => 'role',
            'filter' => AuthItem::allIdToName('name', 'name', [
                'type' => 1
            ]),
            'class' => 'app\mmadmin\grids\FilterColumn'
        ],
        [
            'attribute' => 'is_super',
            'headerOptions' => [
                'width' => '80px'
            ],
            'class' => 'app\mmadmin\grids\BoolColumn'
        ],
        [
            'attribute' => 'status',
            'headerOptions' => [
                'width' => '120px'
            ],
            'filter' => [
                0 => "<span class='text-danger'>未激活</span>",
                10 => "<span class='text-success'>已激活</span>"
            ],
            'class' => 'app\mmadmin\grids\FilterColumn'
        ],
//         [
//             'attribute' => 'created_at',
//             'format' => 'date',
//             'headerOptions' => [
//                 'width' => '120px'
//             ],
//             'class' => 'app\mmadmin\grids\DateTimeColumn'
//         ],

        [
            'class' => 'app\mmadmin\grids\ActionColumn',
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
<?= Html::a('<i class="fa fa-plus"></i> 添加', ['create'], ['class' => 'btn btn-sm btn-link','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?php PanelGridView::end()?>
<?php Pjax::end()?>

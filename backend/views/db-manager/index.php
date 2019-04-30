<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = '数据表';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
PanelGridView::begin(
    [
        'intro' => '数据据表的信息管理',
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute'=>'Name',
                'label'=>'表名'
            ],
            [
                'attribute'=>'Comment',
                'label'=>'备注'
            ],
            [
                'attribute'=>'Engine',
                'label'=>'引擎'
            ],
            [
                'attribute'=>'Rows',
                'label'=>'行'
            ],
            [
                'attribute'=>'Data_length',
                'label'=>'大小'
            ],
            [
                'attribute'=>'Auto_increment',
                'label'=>'ID自增'
            ],
            [
                'attribute'=>'Create_time',
                'label'=>'创建时间'
            ],
            [
                'attribute'=>'Update_time',
                'label'=>'更新时间'
            ],
            [
                'attribute'=>'Collaction',
                'label'=>'字符集'
            ]
        ]
    ]);
?>
<?php PanelGridView::end() ?>


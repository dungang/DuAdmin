<?php
use yii\helpers\Html;
use app\kit\grids\PanelGridView;
/* @var $this yii\web\View */
/* @var $searchModel app\kit\models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '验证规则';
$this->params['breadcrumbs'][] = $this->title;

PanelGridView::begin([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        'name',
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
<p>
    <?= Html::a('添加', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
</p>
<?php PanelGridView::end()?>

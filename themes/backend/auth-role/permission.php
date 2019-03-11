<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\kit\models\AuthItem;
use app\kit\grids\PanelTreeGridView;

/* @var $this yii\web\View */
/* @var $model app\kit\models\AuthRole */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $rights array*/

$this->title = '角色授权';
$this->params['breadcrumbs'][] = [
    'label' => '角色',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        'view',
        'id' => $model->name
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-permissions">
	<?php ActiveForm::begin(); ?>
    <?php
    PanelTreeGridView::begin([
        'intro' => '给角色<strong>'.$model->name.'</strong>分配权限标识',
        'dataProvider' => $dataProvider,
        'keyColumnName' => 'name',
        'parentColumnName' => 'parent',
        'columns' => [
            [
                'attribute' => 'name',
                'label' => '名称',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) use ($rights) {
                    if ($model['type'] == AuthItem::TYPE_PERMISSION) {
                        $checkbox = Html::checkbox('permission[]', in_array($model['name'], $rights), [
                            'value' => $model['name']
                        ]);
                        return $checkbox . $model['name'];
                    } else {
                        return $model['description'];
                    }
                }
            ],
            [
                'attribute' => 'description',
                'label' => '描述',
                'format' => 'ntext',
                'value' => function ($model, $key, $index, $column) {
                    return $model['type'] == AuthItem::TYPE_PERMISSION ? $model['description'] : '';
                }
            ],
            [
                'attribute' => 'rule_name',
                'label' => '规则',
                'value' => function ($model, $key, $index, $column) {
                    return $model['type'] == AuthItem::TYPE_PERMISSION ? $model['rule_name'] : '';
                }
            ]
        ]
    ]);
    ?>
    <p>
        <?= Html::submitButton('<i class="fa fa-save"></i> 保存', ['class' => 'btn btn-sm btn-default']) ?>
    </p>
    
    <?php PanelTreeGridView::end()?>

    <?php ActiveForm::end(); ?>

</div>

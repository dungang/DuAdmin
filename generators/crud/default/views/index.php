<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use app\kit\grids\PanelGridView;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>
    <?= "<?php echo " ?>PanelGridView::begin([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            if($count == 1){
                echo <<<AAA
            [
                'attribute' => '$name',
                'format'=>'raw',
                'value'=>function(\$model,\$key,\$index,\$column){
                    return Html::a(\$model['$name'],['view','id'=>\$model['$name']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],\n
AAA;
            } else 
            echo "            '" . $name . "',\n";
        } else {
            echo "            //'" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            if($count == 1){
                echo <<<AAA
            [
                'attribute' => '$column->name',
                'format'=>'raw',
                'value'=>function(\$model,\$key,\$index,\$column){
                    return Html::a(\$model['$column->name'],['view','id'=>\$model['$column->name']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],\n
AAA;
                
            } else 
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            [
                'class' => '\app\kit\grid\ActionColumn',
                'buttonsOptions'=>[
                    'update'=>[
                        'data-toggle'=>'modal',
                        'data-target'=>'#modal-dailog',
                    ],
                    'view'=>[
                        'data-toggle'=>'modal',
                        'data-target'=>'#modal-dailog',
                    ],
                ]
        	]
       ]
    ]); ?>
<p>
    <?= "<?= " ?>Html::a(<?= $generator->generateString('添加', ['create'], ['class' => 'btn btn-success','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
</p>
<?= "<?php PanelGridView::end() ?>\n"?>
<?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>


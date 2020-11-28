<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

echo "<?php\n";
$labelNames = Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)));
?>

use yii\helpers\Html;
use app\mmadmin\grids\PanelGridView;

<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString($labelNames) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $id_prefix = Inflector::camel2id(StringHelper::basename($generator->modelClass))?>
<?= $generator->enablePjax ? "<?php Pjax::begin(['id'=>'".$id_prefix."-index']); ?>\n" : '' ?>
<?= "<?php  " ?>PanelGridView::begin([
        'id' => '<?= $id_prefix . '-list'?>',
    	'intro' => Yii::t('ma','{0} Info Manage',<?= $generator->generateString($labelNames) ?>),
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            if($count == 1){
                echo <<<AAA
            ['class'=>'\yii\grid\CheckboxColumn'],
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
            ['class'=>'\yii\grid\CheckboxColumn'],
            [
                'attribute' => '$column->name',
                'format'=>'raw',
                'value'=>function(\$model,\$key,\$index,\$column){
                    return Html::a(\$model['$column->name'],['view','id'=>\$model['$column->name']],['data-toggle'=>'modal','data-target'=>'#modal-dailog']);
                }
        	],\n
AAA;
                
            } else {
                if(substr($column->name, -3) == '_at') {
                    echo <<<DATE_FIELD
                    [  
                        'class' => 'app\mmadmin\grids\DateTimeColumn',
                        'attribute' => '$column->name',
                    ],\n
DATE_FIELD;
                } else 
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        } else {
            if(substr($column->name, -3) == '_at') {
                echo <<<DATE_FIELD
                //[  
                //    'class' => 'app\mmadmin\grids\DateTimeColumn',
                //    'attribute' => '$column->name',
                //],\n
DATE_FIELD;
            } else 
                echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            [
                'class' => '\app\mmadmin\grids\ActionColumn',
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
<?="<?= " ?>Html::a('<i class="fa fa-plus"></i> ' . Yii::t('ma','Create'), ['create'], ['class'=>'btn btn-sm btn-link','data-toggle'=>'modal','data-target'=>'#modal-dailog']) ?>
<?="<?= " ?>Html::a('<i class="fa fa-trash"></i> '. Yii::t('ma','Delete'), ['delete'], ['class'=>'btn btn-sm btn-link del-all','data-target'=>'#<?= $id_prefix . '-list'?>']) ?>
<?= "<?php PanelGridView::end() ?>\n"?>
<?= $generator->enablePjax ? "<?php Pjax::end(); ?>\n" : '' ?>


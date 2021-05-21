<?php
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

echo "<?php\n";
$labelNames = Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)));
?>

use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Grids\PanelGridView;
use DuAdmin\Widgets\FullSearchBox;

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
    	'intro' => Yii::t('da','{0} Info Manage',<?= $generator->generateString($labelNames) ?>),
        'dataProvider' => $dataProvider,
        'columns' => [
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
            ['class'=>'\DuAdmin\Grids\CheckboxColumn','name'=>'id'],
            [
                'attribute' => '$column->name',
                'format'=>'raw',
                'value'=>function(\$model,\$key,\$index,\$column){
                    return AppHelper::linkButtonWithSimpleModal(\$model['$column->name'],['view','id'=>\$model['$column->name']]);
                }
        	],\n
AAA;
                
            } else {
              
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        } else {
   
            echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
        
    }
}
?>
            [
                'class' => '\DuAdmin\Grids\ActionColumn',
                'modalSize' => '<?= $generator->getModalSizeClass()?>'
<?php if(!$generator->enableCrudAction):?>
				'template' => '{view}',
<?php else: ?>
<?php $actionTemplate= implode(' ',array_map(function($ac){
    return "{". $ac . "}";
    },array_filter($generator->actions,function($ac){
        return in_array($ac,['view','update','delete']);
    }))) ?>
                'template' => '<?= $actionTemplate?>'
<?php endif;?>
        	]
       ]
    ]); ?>

<?php if($generator->hasStringField()): ?>
<?="<?= " ?>FullSearchBox::widget(['action'=>['index']]) ?> 
<?php endif;?>

<?= "<?= " ?>$this->render('_search', ['model' => $searchModel]); ?>

<?php if ($generator->enableCrudAction): ?>
<?php if (in_array('create',$generator->actions)):?>
<?="<?= " ?>AppHelper::<?=$generator->getLinkFuncName() ?>('<i class="fa fa-plus"></i> ' . Yii::t('da','Create'), ['create'], ['class'=>'btn btn-primary']) ?>
<?php endif;?>
<?="<?= " ?>Html::a('<i class="fa fa-refresh"></i> '. Yii::t('da','Refresh'), ['index'], ['class'=>'btn btn-info']) ?>

<?php if (in_array('delete',$generator->actions)):?>
<?="<?= " ?>Html::a('<i class="fa fa-trash"></i> '. Yii::t('da','Delete'), ['delete'], ['class'=>'btn btn-danger del-all','data-target'=>'#<?= $id_prefix . '-list'?>']) ?>
<?php endif;?>
<?php endif;?>
<?= "<?php PanelGridView::end() ?>\n"?>

<?= $generator->enablePjax ? "<?php Pjax::end(); ?>\n" : '' ?>


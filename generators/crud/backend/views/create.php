<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */
$modelName = Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)));
echo "<?php\n";
?>
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = Yii::t('da','Create');
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString($modelName) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=> Yii::t('da','Create {0} Info',<?= $generator->generateString($modelName) ?>),
    'content'=>$this->render('_form', ['model' => $model,'aciton'=>['create']])
])?>

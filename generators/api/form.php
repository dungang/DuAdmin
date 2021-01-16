<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\api\Generator */

$modeNamespaces = $generator->getModelNamespaces();
echo $form->field($generator, 'modelNamespace')->dropDownList(array_combine($modeNamespaces, $modeNamespaces));
echo $form->field($generator, 'modelName');
$controllerNamespaces = $generator->getApiControllerNamespaces();
echo $form->field($generator, 'controllerNamespace')->dropDownList(array_combine($controllerNamespaces, $controllerNamespaces));
echo $form->field($generator, 'controllerName');
echo $form->field($generator, 'onlyQueryCurrentUser')->checkbox();
echo $form->field($generator, 'enableDefaultOrder')->checkbox();
echo $form->field($generator,'defaultOrder')->dropDownList([
    'SORT_DESC' => 'SORT_DESC(倒序)',
    'SORT_ASC' => 'SORT_ASC(顺序)',
]);
if($generator->modelClass) {
    $fields = $generator->getColumnNames();
    echo $form->field($generator,'defaultOrderField')->dropDownList(array_combine($fields, $fields));
}
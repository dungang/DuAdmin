<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\crud\Generator */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
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
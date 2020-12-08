<?php

use app\generators\model\Generator;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\model\Generator */

echo $form->field($generator, 'tableName')->textInput(['table_prefix' => $generator->getTablePrefix()]);
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'standardizeCapitals')->checkbox();
$namespaces = $generator->getModelNamespaces();
echo $form->field($generator, 'ns')->dropDownList(array_combine($namespaces, $namespaces));
echo $form->field($generator, 'baseClass')->dropDownList([
    'DuAdmin\Core\BaseModel' => 'DUAdmin BaseModel',
    'yii\db\ActiveRecord' => 'Yii ActiveRecord',
]);
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
echo $form->field($generator, 'generateRelations')->dropDownList([
    Generator::RELATIONS_NONE => 'No relations',
    Generator::RELATIONS_ALL => 'All relations',
    Generator::RELATIONS_ALL_INVERSE => 'All relations with inverse',
]);
echo $form->field($generator, 'generateRelationsFromCurrentSchema')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateQuery')->checkbox();
echo $form->field($generator, 'queryNs');
echo $form->field($generator, 'queryClass');
echo $form->field($generator, 'queryBaseClass');
echo $form->field($generator, 'enableI18N')->checkbox();
$messageCategories = $generator->getMessageCatetories();
echo $form->field($generator, 'messageCategory')->dropDownList(array_combine($messageCategories, $messageCategories));
echo $form->field($generator, 'useSchemaName')->checkbox();

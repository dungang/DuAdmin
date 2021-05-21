<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\crud\Generator */

$modeNamespaces = $generator->getModelNamespaces();
echo $form->field($generator, 'modelNamespace')->dropDownList(array_combine($modeNamespaces, $modeNamespaces));
echo $form->field($generator, 'modelName');
$controllerNamespaces = $generator->getWebControllerNamespaces();
echo $form->field($generator, 'controllerNamespace')->dropDownList(array_combine($controllerNamespaces, $controllerNamespaces));
echo $form->field($generator, 'controllerName');
$webViewPathBases = $generator->getWebViewPathBases();
echo $form->field($generator, 'viewPathBase')->dropDownList(array_combine($webViewPathBases, $webViewPathBases));
echo $form->field($generator, 'onlyQueryCurrentUser')->checkbox();
$actions = ['index','create','view','update','delete'];
echo $form->field($generator,'actions')->checkboxList(array_combine($actions,$actions));
echo $form->field($generator, 'baseControllerClass')->dropDownList([
    'DuAdmin\Core\BackendController' => 'DUAdmin BackendController',
    'DuAdmin\Core\FrontendController' => 'DUAdmin FrontendController',
    'DuAdmin\Core\BaseController' => 'DUAdmin BaseController',
    'yii\web\Controller' => 'Yii WebController',
]);
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo $form->field($generator, 'enableCrudAction')->checkbox();
echo $form->field($generator, 'enableDefaultOrder')->checkbox();
echo $form->field($generator,'defaultOrder')->dropDownList([
    'SORT_DESC' => 'SORT_DESC(倒序)',
    'SORT_ASC' => 'SORT_ASC(顺序)',
]);
if($generator->modelClass) {
    $fields = $generator->getColumnNames();
    echo $form->field($generator,'defaultOrderField')->dropDownList(array_combine($fields, $fields));
}
echo $form->field($generator, 'modalSize')->dropDownList([
    'default' => '默认大小',
    'lg' => '大窗口',
    'sm' => '小窗口',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
// $messageCategories = $generator->getMessageCatetories();
// echo $form->field($generator, 'messageCategory')->dropDownList(array_combine($messageCategories, $messageCategories));
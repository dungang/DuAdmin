<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\crud\Generator */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'onlyQueryCurrentUser')->checkbox();
echo $form->field($generator, 'baseControllerClass')->dropDownList([
    'DuAdmin\Core\BackendController' => 'DUAdmin BackendController',
    'DuAdmin\Core\FrontendController' => 'DUAdmin FrontendController',
    'DuAdmin\Core\ApiController' => 'DUAdmin ApiController',
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
    'linkButtonWithSimpleModal' => '默认大小',
    'linkButtonWithBigSimpleModal' => '大窗口',
    'linkButtonWithSmallSimpleModal' => '小窗口',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
$messageCategories = $generator->getMessageCatetories();
echo $form->field($generator, 'messageCategory')->dropDownList(array_combine($messageCategories, $messageCategories));
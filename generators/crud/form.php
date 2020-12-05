<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\crud\Generator */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
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
echo $form->field($generator, 'modalSize')->dropDownList([
    'linkButtonWithSimpleModal' => '默认大小',
    'linkButtonWithBigSimpleModal' => '大窗口',
    'linkButtonWithSmallSimpleModal' => '小窗口',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
$messageCategories = array_keys(Yii::$app->i18n->translations);
echo $form->field($generator, 'messageCategory')->dropDownList(array_combine($messageCategories, $messageCategories));
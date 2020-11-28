<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator app\generators\crud\Generator */

echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'searchModelClass');
echo $form->field($generator, 'controllerClass');
echo $form->field($generator, 'viewPath');
echo $form->field($generator, 'baseControllerClass')->dropDownList([
    'app\mmadmin\core\BackendController' => 'MMAdmin BackendController',
    'app\mmadmin\core\FrontendController' => 'MMAdmin FrontendController',
    'app\mmadmin\core\ApiController' => 'MMAdmin ApiController',
    'app\mmadmin\core\BaseController' => 'MMAdmin BaseController',
    'yii\web\Controller' => 'Yii WebController',
]);
echo $form->field($generator, 'indexWidgetType')->dropDownList([
    'grid' => 'GridView',
    'list' => 'ListView',
]);
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'enablePjax')->checkbox();
echo $form->field($generator, 'messageCategory');
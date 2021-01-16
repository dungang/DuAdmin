<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator app\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?= ltrim($generator->baseControllerClass, '\\') ?>;

<?php $searchModelName = ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "");?>
<?php $modelName = ltrim($generator->modelClass, '\\');?>

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'withModels' => [],
                // 'mustQueryStringAttrs' => [],
<?php if ($generator->onlyQueryCurrentUser): ?>
                'modelImmutableAttrs' => [
                    'userId' => \Yii::$app->user->id,
                ],
<?php else:?>
                // 'modelImmutableAttrs' => [],
<?php endif;?>
                'modelClass' => [
                    'class' => '<?=$searchModelName?>'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'mustQueryStringAttrs' => [],
<?php if ($generator->onlyQueryCurrentUser): ?>
                'modelImmutableAttrs' => [
                    'userId' => \Yii::$app->user->id,
                ],
<?php else:?>
                // 'modelImmutableAttrs' => [],
<?php endif;?>
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
<?php if ($generator->enableCrudAction):?>
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'mustQueryStringAttrs' => [],
<?php if ($generator->onlyQueryCurrentUser): ?>
                'modelImmutableAttrs' => [
                    'userId' => \Yii::$app->user->id,
                ],
<?php else:?>
                // 'modelImmutableAttrs' => [],
<?php endif;?>
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'mustQueryStringAttrs' => [],
<?php if ($generator->onlyQueryCurrentUser): ?>
                'modelImmutableAttrs' => [
                    'userId' => \Yii::$app->user->id,
                ],
<?php else:?>
                // 'modelImmutableAttrs' => [],
<?php endif;?>
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'mustQueryStringAttrs' => [],
<?php if ($generator->onlyQueryCurrentUser): ?>
                'modelImmutableAttrs' => [
                    'userId' => \Yii::$app->user->id,
                ],
<?php else:?>
                // 'modelImmutableAttrs' => [],
<?php endif;?>
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
<?php endif;?>
		];
	}
}
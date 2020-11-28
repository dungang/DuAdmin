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
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => '<?=$searchModelName?>'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelsAction',
                'modelClass' => [
                    'class' => '<?=$modelName?>'
                ]
            ],
		];
	}
}

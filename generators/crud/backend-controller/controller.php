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
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DuAdmin\Helpers\AppHelper;

/**
 * <?= $modelClass ?> 模型的控制器
 * <?= $controllerClass ?> 实现了常规的增删查改等行为 
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{

<?php if (in_array('index',$generator->actions)):?>
    /**
     * 列出所有的 <?= $modelClass ?> 模型.
     * @return mixed
     */
    public function actionIndex()
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
<?php if ($generator->onlyQueryCurrentUser): ?>
        $searchModel->userId = \Yii::$app->user->id;
<?php endif;?>
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }
<?php endif;?>
<?php if (in_array('view',$generator->actions)):?>

    /**
     * 显示单个的 <?= $modelClass ?> 模型数据.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }
<?php endif;?>
<?php if (in_array('create',$generator->actions)):?>

    /**
     * 创建一个新的 <?= $modelClass ?> 模型.
     * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        // ajax表单验证
        if (AppHelper::isAjaxValidationRequest() && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', <?= $urlParams ?>]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
<?php endif;?>
<?php if (in_array('update',$generator->actions)):?>

    /**
     * 更新一条已经存在的 <?= $modelClass ?> 模型.
     * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', <?= $urlParams ?>]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
<?php endif;?>
<?php if (in_array('delete',$generator->actions)):?>

    /**
     * 删除一条存在的 <?= $modelClass ?> 模型.
     * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();

        return $this->redirect(['index']);
    }
<?php endif;?>
<?php if (in_array('update',$generator->actions)||
in_array('view',$generator->actions)||
in_array('delete',$generator->actions)):?>

    /**
     * 根据模型的主键Id查询 <?= $modelClass ?> 模型.
     * 如果模型没有找到,  404 HTTP 异常将会抛出.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
// if (count($pks) === 1) {
//     $condition = '$id';
// } else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    if ($generator->onlyQueryCurrentUser) {
        $condition[] = "'userId' => \\Yii::\$app->user->id";
    }
    $condition = '[' . implode(', ', $condition) . ']';
//}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.') ?>);
    }
<?php endif;?>
}

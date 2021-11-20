<?php
/**
 * This is the template for generating a CRUD controller class file.
 */
use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;
/** @var yii\web\View $this */
/** @var app\generators\crud\Generator $generator */
$controllerClass = StringHelper::basename( $generator->controllerClass );
$modelClass = StringHelper::basename( $generator->modelClass );
$searchModelClass = StringHelper::basename( $generator->searchModelClass );
if ( $modelClass === $searchModelClass ) {
  $searchModelAlias = $searchModelClass . 'Search';
}
/** @var ActiveRecordInterface $class */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
echo "<?php\n";
?>

namespace <?=StringHelper::dirname( ltrim( $generator->controllerClass, '\\' ) )?>;

use Yii;
use yii\web\NotFoundHttpException;
use <?=ltrim( $generator->modelClass, '\\' )?>;
<?php
if ( ! empty( $generator->searchModelClass ) ) :
  ?>
use <?=ltrim( $generator->searchModelClass, '\\' ) . (isset( $searchModelAlias ) ? " as $searchModelAlias" : "")?>;
<?php
else :
  ?>
use yii\data\ActiveDataProvider;
<?php
endif;
?>
use <?=ltrim( $generator->baseControllerClass, '\\' )?>;

/**
 * <?=$modelClass?> 模型的控制器
 * <?=$controllerClass?> 实现了常规的增删查改等行为
 */
class <?=$controllerClass?> extends <?=StringHelper::basename( $generator->baseControllerClass ) . "\n"?>
{
<?php
if ( in_array( 'delete', $generator->actions ) ) :
  ?>
    /**
     * 请求action 方法设置
     * @var array
     */
     public $verbsActions = ['delete' => ['POST']];
<?php endif;

if ( in_array( 'index', $generator->actions ) ) :
  ?>
    /**
     * 列出所有的 <?=$modelClass?> 模型.
     * @return mixed
     */
    public function actionIndex()
    {
<?php
  if ( ! empty( $generator->searchModelClass ) ) :
    ?>
        $searchModel = new <?=isset( $searchModelAlias ) ? $searchModelAlias : $searchModelClass?>();
        $queryParams = Yii::$app->request->queryParams;
<?php if ( $generator->onlyQueryCurrentUser ) : ?>
        $queryParams['userId'] = \Yii::$app->user->id;
<?php endif;?>
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php
  else :
    ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?=$modelClass?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php
  endif;
  ?>
    }
<?php endif;

if ( in_array( 'view', $generator->actions ) ) :
  ?>

    /**
     * 显示单个的 <?=$modelClass?> 模型数据.
     * <?=implode( "\n     * ", $actionParamComments ) . "\n"?>
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(<?=$actionParams?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?=$actionParams?>),
        ]);
    }
<?php endif;

if ( in_array( 'create', $generator->actions ) ) :
  ?>

    /**
     * 创建一个新的 <?=$modelClass?> 模型.
     * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?=$modelClass?>();

        // ajax表单验证
        if ( ($error = $this->ajaxValidation( $model )) !== false ) {
            return $error;
        }

        if ($model->load(Yii::$app->request->post())) {
<?php if ( $generator->onlyQueryCurrentUser ) : ?>
            $model->userId = \Yii::$app->user->id;
<?php endif;?>
            return Yii::$app->db->transaction(function ($db) use ($model) {
              $model->save();
              return $this->redirectSuccess(['view', <?=$urlParams?>], "添加成功");
            });
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
<?php endif;

if ( in_array( 'update', $generator->actions ) ) :
  ?>

    /**
     * 更新一条已经存在的 <?=$modelClass?> 模型.
     * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
     * <?=implode( "\n     * ", $actionParamComments ) . "\n"?>
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionUpdate(<?=$actionParams?>)
    {
        $model = $this->findModel(<?=$actionParams?>);

        // ajax表单验证
        if ( ($error = $this->ajaxValidation( $model )) !== false ) {
            return $error;
        }

        if ($model->load(Yii::$app->request->post())) {
          return Yii::$app->db->transaction(function ($db) use ($model) {
              $model->save();
              return $this->redirectSuccess(['view', <?=$urlParams?>], "修改成功");
          });
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
<?php endif;

$condition = [ ];
foreach ( $pks as $pk ) {
  $condition [] = "'$pk' => \$$pk";
}
if ( $generator->onlyQueryCurrentUser ) {
  $condition [] = "'userId' => \\Yii::\$app->user->id";
}
$condition = '[' . implode( ', ', $condition ) . ']';
if ( in_array( 'delete', $generator->actions ) ) :
  ?>

    /**
     * 删除一条存在的 <?=$modelClass?> 模型.
     * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionDelete()
    {
      //如果这里不正确，请给表添加一个主键Id
      <?=$actionParams?> = Yii::$app->request->post('id');
      if(!<?=$actionParams?>) {
        <?=$actionParams?> = Yii::$app->request->get('id');
      }
    	if( is_array(<?=$actionParams?>) ) {
    		$modelList = <?=$modelClass?>::findAll(<?=$condition?>);
    		if( $modelList ) {
    			foreach($modelList as $model) {
            Yii::$app->db->transaction(function ($db) use ($model) {
    				  $model->delete();
            });
    			}
    		}
    	} else {
        Yii::$app->db->transaction(function ($db) use (<?=$actionParams?>) {
        	$this->findModel(<?=$actionParams?>)->delete();
        });
    	}
        return $this->redirect(Yii::$app->request->referrer);
    }
<?php endif;

if ( in_array( 'update', $generator->actions ) || in_array( 'view', $generator->actions ) || in_array( 'delete', $generator->actions ) ) :
  ?>

    /**
     * 根据模型的主键Id查询 <?=$modelClass?> 模型.
     * 如果模型没有找到,  404 HTTP 异常将会抛出.
     * <?=implode( "\n     * ", $actionParamComments ) . "\n"?>
     * @return <?=$modelClass?> the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel(<?=$actionParams?>)
    {

        if (($model = <?=$modelClass?>::findOne(<?=$condition?>)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(<?=$generator->generateString( 'The requested page does not exist.' )?>);
    }
<?php endif; ?>
}

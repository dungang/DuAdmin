<?php

namespace app\kit\core;

use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 *
 * @author dungang
 * @property BaseController $controller 控制器
 * @property array $modelBehaviors 模型的行为
 * @property array $actionBehaviors action的行为
 */
class BaseAction extends Action
{

    const EVENT_BEFORE_RUN = 'actionBeforeRun';

    const EVENT_AFTER_RUN = 'actionAfterRun';

    /**
     * view 文件的名称
     *
     * @var string
     */
    public $viewName;

    /**
     * action的行为
     *
     * @var string
     */
    protected $_actionBehaviors = [];

    /**
     * 模型的行为
     *
     * @var array
     */
    protected $_modelBehaviors = [];

    /**
     * 模型配置参数
     * \Yii::createObject 的参数
     * ['class'=>'className','prop'=>'val']
     *
     * @var array|string
     */
    public $modelClass = null;

    /**
     * 固定的对象属性，
     * 整合了之前的 findParams 和 assignParams
     * 在很多场景下，findParams assignParams 是一直的所以没有必要使用两个参数来区分。
     * 很难理解。
     * 
     * 比如查询对象的时候必须在代码内部确定的属性。查询当前用户的数据，
     * 为什么要做这样的参数设置。
     * Yii有个优点也是缺点，模型load的时候可以任意覆盖，如果不约束就会有注入的风险，
     * 不通过这种方式也是可以的，配置模型的安全属性，safe，但是这样会导致模型文件的维护复杂
     * 随着业务的增加，对一个模型的需求就会出现不同场景（属性数量的不同）在rules方法章充满了各种场景，已经复杂的组合。
     * 还不入直接通过参数约束。
     * 
     * 可以参考用户表（当会员和管理员同表的场景），用户表即代表了管理员也可以代表会员
     *
     * @var array|null
     */
    public $baseAttrs = null;

    /**
     * 条件查找参数
     * @deprecated 请使用 baseAttrs
     * @var array|null
     */
    public $findParams = null;

    /**
     * 固定赋值参数
     * @deprecated 请使用 baseAttrs
     * @var null|array
     */
    public $assignParams = null;

    /**
     * 成功操作的跳转地址，如果没有设置，则使用默认的
     *
     * @var string
     */
    public $successRediretUrl = false;

    /**
     * 文本消息
     *
     * @var string
     */
    public $successMsg = '添加成功';

    /**
     * 输出到视图的数据
     *
     * @var array
     */
    public $data = [] ;

    public function init()
    {
        if (empty($this->viewName)) {
            $this->viewName = $this->id;
        }
        if (!empty($this->actionBehaviors)) {
            $this->attachBehaviors($this->actionBehaviors);
        }
        if ($this->baseAttrs) {
            $this->findParams = $this->baseAttrs;
            $this->assignParams = $this->baseAttrs;
        }
    }

    public function getActionBehaviors()
    {
        if ($this->_actionBehaviors) {
            foreach ($this->_actionBehaviors as $key => &$val) {
                if (is_callable($val)) {
                    $this->_actionBehaviors[$key] = call_user_func($val);
                }
            }
        }
        return $this->_actionBehaviors;
    }

    public function setActionBehaviors($behaviors)
    {
        $this->_actionBehaviors = $behaviors;
    }

    public function getModelBehaviors()
    {
        if ($this->_modelBehaviors) {
            foreach ($this->_modelBehaviors as $key => &$val) {
                if (is_callable($val)) {
                    $this->_modelBehaviors[$key] = call_user_func($val);
                }
            }
        }
        return $this->_modelBehaviors;
    }

    public function setModelBehaviors($behaviors)
    {
        $this->_modelBehaviors = $behaviors;
    }

    protected function isPost()
    {
        return \Yii::$app->request->isPost;
    }

    /**
     * 设置固定的参数，避免被外部覆盖
     *
     * @param Model $model
     * @return boolean
     */
    protected function setAssignParams($model)
    {
        if ($this->assignParams) {
            foreach ($this->assignParams as $field => $val) {
                $model->{$field} = $val;
            }
        }
        return true;
    }

    /**
     * 获取get参数
     *
     * @param Model $model
     */
    protected function composeGetParams($model)
    {
        $params = \Yii::$app->request->queryParams;
        if ($this->findParams) {
            $formName = $model->formName();
            if (empty($params[$formName]))
                $params[$formName] = [];
            $params[$formName] = \array_merge($params[$formName], $this->findParams);
        }
        return $params;
    }

    /**
     * 获取post参数
     *
     * @param Model $model
     * @param bool $multiple
     *            是否多模型
     */
    protected function composePostParams($model, $multiple = false)
    {
        $params = \Yii::$app->request->post();
        if ($this->assignParams) {
            $formName = $model->formName();
            if (empty($params[$formName]))
                $params[$formName] = [];
            if ($multiple === false) {
                $params[$formName] = \array_merge($params[$formName], $this->assignParams);
            } else {
                foreach ($params[$formName] as $i => $param) {
                    $params[$formName][$i] = \array_merge($param, $this->assignParams);
                }
            }
        }
        return $params;
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Action::afterRun()
     */
    protected function afterRun()
    {
        $this->trigger(self::EVENT_AFTER_RUN);
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Action::beforeRun()
     */
    protected function beforeRun()
    {
        $this->trigger(self::EVENT_BEFORE_RUN);
        return parent::beforeRun();
    }


    /**
     * 计算跳转的参数或url
     * @param BaseModel $model
     * @return mixed[]|string
     */
    protected function getSuccessRediretUrlWidthModel($model)
    {
        if (is_array($this->successRediretUrl)) {
            $url = [];
            $url[] = \array_shift($this->successRediretUrl);
            foreach ($this->successRediretUrl as $p => $f) {
                $url[$p] = $model[$f];
            }
            return $url;
        }
        return $this->successRediretUrl;
    }

    /**
     * 获取模型的主键，并自动装配了关系数组
     *
     * @param \yii\db\ActiveRecordInterface $class
     * @throws InvalidConfigException
     * @return mixed|bool
     */
    protected function getPrimaryKeyCondition($class)
    {
        // query by primary key
        if (method_exists($class, 'primaryKey')) {
            $primaryKey = $class::primaryKey();
            $cond = [];
            foreach ($primaryKey as $key) {
                $cond[$key] = \Yii::$app->request->get($key);
            }
            return $cond;
        }
        return null;
    }

    /**
     * 查找一个模型对象实例
     *
     * @param boolean $createOneOnNotFound
     * @throws NotFoundHttpException
     * @return mixed|object|ActiveRecord
     */
    protected function findModel($createOneOnNotFound = false)
    {
        /* @var $model ActiveRecord */
        $model = null;
        $scenario = Model::SCENARIO_DEFAULT;
        if ($this->modelClass) {
            if (is_string($this->modelClass)) {
                $class = $this->modelClass;
                $args = [];
            } else if (is_array($this->modelClass) && isset($this->modelClass['class'])) {
                $args = $this->modelClass;
                $class = array_shift($args);
            }
            if (isset($args['scenario'])) {
                $scenario = $args['scenario'];
                unset($args['scenario']);
            }
            if ($class) {

                $condition = array_merge($this->getPrimaryKeyCondition($class), $args ?: []);

                //是否设置了查找的固定参数
                if ($this->findParams) {
                    $condition = \array_merge($condition, $this->findParams);
                }
                $model = call_user_func(array(
                    $class,
                    'findOne'
                ), $this->clearCond($condition));
            }
        }
        if ($model !== null) {
            $model->setScenario($scenario);
            return $model;
        } else if ($createOneOnNotFound) {
            return \Yii::createObject([
                'class' => $this->modelClass,
                'scenario' => $scenario
            ]);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 根据多个id查找，目前该方法还不完善
     *
     * @param array $ids
     * @throws NotFoundHttpException
     * @return mixed
     */
    protected function findModels($ids)
    {
        $models = null;
        if ($this->modelClass) {
            $class = $this->modelClass;
            if (is_array($this->modelClass) && isset($this->modelClass['class'])) {
                $class = $this->modelClass['class'];
            }
            $cond = [
                'id' => $ids
            ];

            //是否设置了查找的固定参数
            if ($this->findParams) {
                $cond = \array_merge($cond, $this->findParams);
            }
            $models = call_user_func(array(
                $class,
                'findAll'
            ), $this->clearCond($cond));
        }
        if ($models !== null) {
            return $models;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function clearCond($cond)
    {
        return \array_filter($cond, function ($val) {
            return !\is_null($val);
        });
    }
}

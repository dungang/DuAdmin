<?php

namespace DuAdmin\Core;

use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 *
 * @author dungang
 * @property BaseController $controller 控制器
 * @property array $modelBehaviors 模型的行为
 * @property array $actionBehaviors action的行为
 */
abstract class BaseAction extends Action
{

    const EVENT_BEFORE_RUN = 'actionBeforeRun';

    const EVENT_AFTER_RUN = 'actionAfterRun';

    const EVENT_BEFORE_RENDER = 'actionBeforeRender';

    /**
     * view 文件的名称
     *
     * @var string
     */
    public $viewName;

    /**
     * action的行为
     *
     * @var array
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
     * 比如查询对象的时候必须在代码内部确定的属性。查询当前用户的数据，
     * 为什么要做这样的参数设置。
     * Yii有个优点也是缺点，模型load的时候可以任意覆盖，如果不约束就会有注入的风险，
     * 不通过这种方式也是可以的，配置模型的安全属性，safe，但是这样会导致模型文件的维护复杂
     * 随着业务的增加，对一个模型的需求就会出现不同场景（属性数量的不同）在rules方法章充满了各种场景，已经复杂的组合。
     * 还不入直接通过参数约束。
     * 
     * 比如：当会员和管理员同表的场景，用户表即代表了管理员也可以代表会员
     *
     * @var array|null
     */
    public $modelImmutableAttrs = null;


    public $modelScenario = 'default';

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
    public $successMsg;

    /**
     * 输出到视图的数据
     *
     * @var array
     */
    public $data = [];

    public function init()
    {
        if (empty($this->viewName)) {
            $this->viewName = $this->id;
        }
        if (!empty($this->actionBehaviors)) {
            $this->attachBehaviors($this->actionBehaviors);
        }
        if (empty($this->successMsg)) {
            $this->successMsg = Yii::t('da', 'Create success');
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
    protected function overrideModelImmutableAttrs($model)
    {
        if ($this->modelImmutableAttrs) {
            foreach ($this->modelImmutableAttrs as $field => $val) {
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
        if ($this->modelImmutableAttrs) {
            $formName = $model->formName();
            if (empty($params[$formName]))
                $params[$formName] = [];
            $params[$formName] = ArrayHelper::merge($params[$formName], $this->modelImmutableAttrs);
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
        if ($this->modelImmutableAttrs) {
            $formName = $model->formName();
            if (empty($params[$formName]))
                $params[$formName] = [];
            if ($multiple === false) {
                $params[$formName] = ArrayHelper::merge($params[$formName], $this->modelImmutableAttrs);
            } else {
                foreach ($params[$formName] as $i => $param) {
                    $params[$formName][$i] = ArrayHelper::merge($param, $this->modelImmutableAttrs);
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
     * 试图在渲染之前
     *
     * @return void
     */
    protected function beforeRender()
    {

        $this->trigger(self::EVENT_BEFORE_RENDER);
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
     * @param \yii\db\ActiveRecordInterface $modelClass
     * @throws InvalidConfigException
     * @return mixed|bool
     */
    protected function getPrimaryKeyCondition($modelClass)
    {
        // query by primary key
        if (method_exists($modelClass, 'primaryKey')) {
            $primaryKey = $modelClass::primaryKey();
            $cond = [];
            $params = ArrayHelper::merge(\Yii::$app->request->get(), \Yii::$app->request->post());
            foreach ($primaryKey as $key) {
                if (isset($params[$key])) {
                    $cond[$key] = $params[$key];
                }
            }
            if (empty($cond) && isset($params['id'])) {
                $cond['id'] = $params['id'];
            }
            return $cond;
        }
        return null;
    }

    /**
     * 构建查询模型的参数
     *
     * @return array
     */
    protected function builderFindModelCondition()
    {
        if (is_string($this->modelClass)) {
            // 如果模型类用了字符串参数
            $modelClass = $this->modelClass;
            $args = [];
        } else if (is_array($this->modelClass) && isset($this->modelClass['class'])) {
            // 如果模型类使用是数组构成（yii2规范，必须用class指定模型类）
            $modelClass = $this->modelClass['class'];
            $args = $this->modelClass;
            $args['class'] = null;
        } else {
            throw new InvalidConfigException('Action must set modelClass');
        }
        //自动查找主键过滤条件
        $condition = ArrayHelper::merge($args ?: [], $this->getPrimaryKeyCondition($modelClass));
        //是否设置了查找的固定参数
        if ($this->modelImmutableAttrs) {
            $condition = ArrayHelper::merge($condition, $this->modelImmutableAttrs);
        }
        return [$modelClass, $this->clearNullCond($condition)];
    }

    /**
     * 查找一个模型对象实例通过主键，自动获取主键
     *
     * @param boolean $newOneOnNotFound
     * @throws NotFoundHttpException
     * @return mixed|object|ActiveRecord
     */
    protected function findModel($newOneOnNotFound = false)
    {
        list($modelClass, $condition) = $this->builderFindModelCondition();
        /* @var $model \yii\db\ActiveRecord */
        $model = call_user_func(array(
            $modelClass,
            'findOne'
        ), $condition);
        if ($model !== null) {
            $model->setScenario($this->modelScenario);
            return $model;
        } else if ($newOneOnNotFound) {
            $model = \Yii::createObject($modelClass,$condition);
            $model->setScenario($this->modelScenario);
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 根据PK查找，自动获取PK名称，目前该方法还不完善
     *
     * @throws NotFoundHttpException
     * @return mixed
     */
    protected function findModels()
    {
        list($modelClass, $condition) = $this->builderFindModelCondition();
        /* @var $models \yii\db\ActiveRecord[] */
        $models = call_user_func(array(
            $modelClass,
            'findAll'
        ), $condition);
        if ($models !== null) {
            return array_map(function ($model) {
                $model->setScenario($this->modelScenario);
                return $model;
            }, $models);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 判断是否是ajax请求，主要是区分表单的ajax验证
     * @return boolean
     */
    protected function isAjaxNotPjax()
    {
        return Yii::$app->request->isAjax && Yii::$app->request->isPjax === false;
    }

    /**
     * 清理null的参数
     *
     * @param array $cond
     * @return array
     */
    protected function clearNullCond($cond)
    {
        return \array_filter($cond, function ($val) {
            return !\is_null($val);
        });
    }
}

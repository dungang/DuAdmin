<?php

namespace DuAdmin\Core;

use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;

trait ActionTrait
{


    public $loadFormName = true;

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

    /**
     * 必须传递的属性
     *
     * @var null|array
     */
    public $mustQueryStringAttrs = null;

    /**
     * 模型场景
     *
     * @var string
     */
    public $modelScenario = 'default';

    public function init()
    {
        $this->checkQueryStringAttrs();
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
            if ($this->loadFormName) {
                $formName = $model->formName();
                if (empty($params[$formName]))
                    $params[$formName] = [];
                $params[$formName] = ArrayHelper::merge($params[$formName], $this->modelImmutableAttrs);
            } else {
                $params = ArrayHelper::merge($params, $this->modelImmutableAttrs);
            }
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
            if ($this->loadFormName) {
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
            } else {
                if ($multiple === false) {
                    $params = ArrayHelper::merge($params, $this->modelImmutableAttrs);
                } else {
                    foreach ($params as $i => $param) {
                        $params[$i] = ArrayHelper::merge($param, $this->modelImmutableAttrs);
                    }
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
        $this->trigger('actionAfterRun');
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Action::beforeRun()
     */
    protected function beforeRun()
    {
        $this->trigger('actionBeforeRun');
        return parent::beforeRun();
    }

    /**
     * 计算跳转的参数或url
     *
     * @param BaseModel $model
     * @return mixed[]|string
     */
    protected function getSuccessRediretUrlWidthModel($model)
    {
        if (is_array($this->successRediretUrl)) {
            $url = [];
            $url[] = \array_shift($this->successRediretUrl);
            foreach ($this->successRediretUrl as $p => $f) {
                if (is_numeric($p)) {
                    $url[$f] = $model[$f];
                } else {

                    $url[$p] = $model[$f];
                }
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
            $primaryKey = call_user_func([
                $modelClass,
                'primaryKey'
            ]);
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
     * @param
     *            $filter
     * @return array
     */
    protected function builderFindModelCondition($fitler = [])
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
        // 自动查找主键过滤条件
        $condition = ArrayHelper::merge($args ?: [], $this->getPrimaryKeyCondition($modelClass), $fitler);

        // 是否设置了查找的固定参数
        if ($this->modelImmutableAttrs) {
            $condition = ArrayHelper::merge($condition, $this->modelImmutableAttrs);
        }
        unset($condition['class']);

        return [
            $modelClass,
            $this->clearNullCond($condition)
        ];
    }

    /**
     * 查找一个模型对象实例通过主键，自动获取主键
     *
     * @param boolean $newOneOnNotFound
     * @param
     *            $filter
     * @throws NotFoundHttpException
     * @return mixed|object|ActiveRecord
     */
    protected function findModel($newOneOnNotFound = false, $filter = [])
    {
        list($modelClass, $condition) = $this->builderFindModelCondition($filter);
        if (empty($condition)) {
            throw new BadRequestHttpException('Find model must set filters');
        }

        /* @var $model \yii\db\ActiveRecord */
        // https://www.yiichina.com/doc/guide/2.0/db-active-record
        // 提示： yii\db\ActiveRecord::findOne() 和 yii\db\ActiveQuery::one()
        // 都不会添加 LIMIT 1 到 生成的 SQL 语句中。
        // 如果你的查询会返回很多行的数据， 你明确的应该加上 limit(1) 来提高性能，
        // 比如 Customer::find()->limit(1)->one()。
        if (method_exists($modelClass, 'find')) {
            $model = $modelClass::find()->where($condition)
                ->limit(1)
                ->one();
        } else if (method_exists($modelClass, 'findOne')) {
            $model = call_user_func($modelClass, 'findOne', $condition);
        } else {
            throw new MethodNotAllowedHttpException();
        }
        if ($model !== null) {
            if (!is_array($model)) {
                $model->setScenario($this->modelScenario);
            }
            return $model;
        } else if ($newOneOnNotFound) {
            $model = new $modelClass($condition);
            $model->setScenario($this->modelScenario);
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 根据PK查找，自动获取PK名称，目前该方法还不完善
     *
     * @param
     *            $filter
     * @throws NotFoundHttpException
     * @return mixed
     */
    protected function findModels($filter = [])
    {
        list($modelClass, $condition) = $this->builderFindModelCondition();
        if (empty($condition)) {
            throw new BadRequestHttpException('Find model must set filters');
        }
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

    /**
     * 自动发现formName
     *
     * @return mixed
     */
    protected function discoverFormName()
    {
        if (is_array($this->modelClass)) {
            $className = $this->modelClass['class'];
        } else {
            $className = $this->modelClass;
        }
        $pieces = explode('\\', $className);
        return array_pop($pieces);
    }

    /**
     * 检查querystring必须传递的参数
     *
     * @throws BadRequestHttpException
     */
    protected function checkQueryStringAttrs()
    {
        if ($this->mustQueryStringAttrs && is_array($this->mustQueryStringAttrs)) {
            foreach ($this->mustQueryStringAttrs as $field) {
                if (\Yii::$app->request->queryParams[$field] === null) {
                    throw new BadRequestHttpException('Lost Query Params');
                }
            }
        }
    }
}

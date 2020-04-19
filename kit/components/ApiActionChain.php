<?php

namespace app\kit\components;

use Yii;
use yii\base\Component;
use yii\base\DynamicModel;
use yii\base\Event;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;

class MyDynamicModel extends DynamicModel
{
    public $attributeLabels = [];

    public function attributeLabels()
    {
        return $this->attributeLabels;
    }
}

class ApiActionChain extends Component
{
    const BEFORE_PROCESS = 'beforeProcess';

    /**
     * 行为查询的数据缓存
     */
    public $behaviorPayloads = [];

    /**
     * 数据
     * @var array
     */
    private $data = [];

    /**
     * 接受的字段
     * @var array
     */
    private $fields = [];


    /**
     * 验证规则
     * @var array
     */
    private $fieldsRules = [];

    /**
     * 是否通过
     */
    private $pass = true;

    /**
     * 是否表单验证
     */
    private $validate = true;

    /**
     * 错误消息
     */
    private $message = '';


    /**
     * 获取一个链的实例
     * @return ApiActionChain
     */
    public static function getInstance()
    {
        return new ApiActionChain();
    }

    public function disableValidate()
    {
        $this->validate = false;
        return $this;
    }

    /**
     * 不通过
     * @param string $message 
     * @return ApiActionChain
     */
    public function depass($message)
    {
        $this->pass = false;
        $this->message = $message;
        return $this;
    }

    /**
     * 必须是POST请求
     * @return ApiActionChain
     */
    public function mustPost()
    {
        if ($this->pass && Yii::$app->request->isPost)
            $this->data = Yii::$app->request->bodyParams;
        else
            $this->depass('必须是POST请求');
        return $this;
    }

    /**
     * 必须是GET请求
     * @return ApiActionChain
     */
    public function mustGet()
    {
        if ($this->pass && Yii::$app->request->isGet)
            $this->data = Yii::$app->request->get();
        else
            $this->depass('必须是GET请求');
        return $this;
    }

    /**
     * 设置字段的验证规则
     * @param array $fields
     * @return ApiActionChain
     */
    public function setFields($fields)
    {
        if ($this->pass && $fields)
            $this->fields = $fields;
        return $this;
    }

    /**
     * 设置字段的验证规则
     * @param array $rules
     * @return ApiActionChain
     */
    public function setFieldsRules($rules)
    {
        if ($this->pass && $rules)
            $this->fieldsRules = $rules;
        return $this;
    }

    /**
     * @param yii\base\DynamicModel $model
     */
    public function beforeProcess($model)
    {
        $event = new Event();
        $event->data = $model;
        $this->trigger(static::BEFORE_PROCESS, $event);
    }


    private function process($callback, $model = null)
    {

        $this->beforeProcess($model);
        return call_user_func($callback, $this->data, $model, $this->behaviorPayloads);
    }

    private function bindBehaviors($behaviors, $model = null)
    {
        if ($behaviors) {
            if (is_callable($behaviors)) {
                $this->attachBehaviors(call_user_func($behaviors, $model));
            } else {
                $this->attachBehaviors($behaviors);
            }
        }
    }

    /**
     * 最后执行返回
     * @param callable $callback
     * @param callable|string|array $behaviors
     * @return array
     */
    public function done($callback, $behaviors = null)
    {
        if ($this->pass) {

            if ($this->validate) {
                $model = MyDynamicModel::validateData(array_keys($this->fields), $this->fieldsRules);
                $model->attributeLabels = $this->fields;
                $model->load($this->data, '');
                //if ($model->load($this->data, '')) {
                    if ($model->validate()) {
                        $this->bindBehaviors($behaviors, $model);
                        return $this->process($callback, $model);
                    }

                    if ($model->hasErrors()) {
                        throw new InvalidArgumentException(current(array_values($model->getFirstErrors())), 400);
                    }
                //}
                //throw new BadRequestHttpException('参数无效', 400);
            }
            $this->bindBehaviors($behaviors, $model);
            return $this->process($callback);
        }
        throw new ForbiddenHttpException($this->message, 403);
    }
}

<?php

namespace DuAdmin\Core;

use yii\helpers\ArrayHelper;
use DuAdmin\Behaviors\PropertyBehavior;
use DuAdmin\Events\BeforeSearchEvent;
use DuAdmin\Mysql\ActiveRecord;
use Exception;
use JsonSerializable;
use Yii;
use yii\helpers\Json;

class BaseModel extends ActiveRecord implements JsonSerializable
{

    /**
     * 对象json序列化的时候设置不显示的字段
     *
     * @var array
     */
    public $jsonHideFields = [];

    /**
     * 存储的数据是json的字段
     *
     * @var array
     */
    public $jsonFields = [];

    const EVENT_AFTER_VIEW = 'afterView';

    /**
     * searchModel 在搜索前执行的事件
     */
    const EVNT_BEFORE_SEARCH = 'beforeSearch';

    /**
     * 只查询没有标记删除的数据
     */
    protected $_query_only_undel = true;

    /**
     *
     * {@inheritdoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        $ary = null;
        if (empty($this->jsonHideFields)) {
            $ary = $this->toArray([], $this->extraFields());
        } else {
            $ary =  array_filter($this->toArray([], $this->extraFields()), function ($key) {
                return in_array($key, $this->jsonHideFields) == false;
            }, ARRAY_FILTER_USE_KEY);
        }
        if ($this->jsonFields) {
            foreach ($this->jsonFields as $field) {
                if (isset($ary[$field])) {
                    try {
                        $ary[$field] = Json::decode($ary[$field]);
                    } catch(Exception $ex) {
                        Yii::error('field:' . $field .' json decode exception.' . $ex->getMessage());
                        $ary[$field] = null;
                    }
                }
            }
        }
        return $ary;
    }

    public function init()
    {
        parent::init();
        // 是否有软删除字段
        if ($this->hasDeleteProperty()) {
            $this->isDel = 0;
        }
    }

    public function behaviors()
    {
        return [
            PropertyBehavior::className()
        ];
    }

    /**
     * Sets the attribute values in a massive way.
     *
     * @param array $values
     *            attribute values (name => value) to be assigned to the model.
     * @param bool $safeOnly
     *            whether the assignments should only be done to the safe attributes.
     *            A safe attribute is one that is associated with a validation rule in the current [[scenario]].
     * @see safeAttributes()
     * @see attributes()
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (is_array($values)) {
            $attributes = array_flip($safeOnly ? $this->safeAttributes() : $this->attributes());
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    $this->$name = $value;
                } elseif ($safeOnly) {
                    $this->onUnsafeAttribute($name, $value);
                }
            }
        }
    }

    /**
     * between
     *
     * @param string $field
     * @param string $value
     * @return array
     */
    public function filterBetween($field, $value)
    {
        if ($value) {
            if (is_array($value)) {
                if (count($value) > 1) {
                    return [
                        'between',
                        $field,
                        $value[0],
                        $value[1]
                    ];
                } else {
                    return [
                        '>=',
                        $field,
                        $value[0]
                    ];
                }
            }
        }
        return [
            $field => $value
        ];
    }

    /**
     * 默认开启所有操作的事务
     */
    public function transactions()
    {
        return [
            static::SCENARIO_DEFAULT => static::OP_ALL
        ];
    }

    /**
     * 不是物理删除，而是状态删除
     * 通知isDel字段来标记
     *
     * @return boolean
     */
    protected function hasDeleteProperty()
    {
        return $this->hasProperty("isDel");
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\db\ActiveRecord::delete()
     */
    public function delete()
    {
        if ($this->hasDeleteProperty()) {
            $this->isDel = 1;
            $result = $this->update(false);
            return $result;
        }
        return parent::delete();
    }

    /**
     *
     * @param array $counters
     * @return int
     */
    public function counter($counters)
    {
        foreach ($counters as $field => $value) {
            $this->$field = $this->$field + $value;
        }
        return $this->save(false);
    }

    /**
     * 复制属性
     *
     * @param \yii\base\Model $from_model
     * @return void
     */
    public function copyAttrs($from_model)
    {
        $attrs = array_keys($this->getAttributes());
        foreach ($attrs as $attr) {
            if ($from_model->hasProperty($attr)) {
                $this->$attr = $from_model->$attr;
            }
        }
        return $this;
    }

    /**
     * 搜索模型在收索前执行的事件，
     * 对参数和query做修改
     *
     * @param \yii\db\ActiveQuery $query
     * @param array $params
     * @return void
     */
    public function beforeSearch($query, &$params)
    {
        $event = new BeforeSearchEvent([
            'query' => $query,
            'params' => $params
        ]);
        $this->trigger(self::EVNT_BEFORE_SEARCH, $event);
        // $params = $event->params;
        // $query = $event->query;
    }

    public static function allIdToName($key = 'id', $val = 'name', $where = null, $orderBy = null)
    {
        $models = self::find()->select("$key,$val")
            ->where($where)
            ->orderBy($orderBy)
            ->asArray()
            ->all();
        if (is_array($models)) {
            return ArrayHelper::map($models, $key, $val);
        }
        return $models;
    }

    /**
     * 获取去除namespace的类名
     *
     * @return mixed
     */
    public static function getClassShortName()
    {
        return array_pop(explode("\\", get_called_class()));
    }
}

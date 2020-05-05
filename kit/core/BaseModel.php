<?php

namespace app\kit\core;

use yii\helpers\ArrayHelper;
use app\kit\behaviors\PropertyBehavior;
use app\kit\events\BeforeSearchEvent;
use app\kit\mysql\ActiveRecord;

class BaseModel extends ActiveRecord
{

    const EVENT_AFTER_VIEW = 'afterView';

    /**
     * searchModel 在搜索前执行的事件
     */
    const EVNT_BEFORE_SEARCH = 'beforeSearch';

    /**
     * 只查询没有标记删除的数据
     */
    protected $_query_only_undel = true;

    public function init()
    {
        parent::init();
        if ($this->hasDeleteProperty()) {
            $this->is_del = 0;
        }
    }

    public function behaviors()
    {
        return [
            PropertyBehavior::className()
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
     * 通知is_del字段来标记
     *
     * @return boolean
     */
    protected function hasDeleteProperty()
    {
        return $this->hasProperty("is_del");
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\db\ActiveRecord::delete()
     */
    public function delete()
    {
        if ($this->hasDeleteProperty()) {
            $this->is_del = 1;
            $result = $this->update(false);
            return $result;
        }
        return parent::delete();
    }


    /**
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
     * 搜索模型在收索前执行的事件，
     * 对参数和query做修改
     *
     * @param \yii\db\ActiveQuery $query
     * @param array $params
     * @return void
     */
    public function beforeSearch(&$query, &$params)
    {
        $event = new BeforeSearchEvent([
            'query' => $query,
            'params' => $params
        ]);
        $this->trigger(self::EVNT_BEFORE_SEARCH, $event);
        $params = $event->params;
        $query = $event->query;
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

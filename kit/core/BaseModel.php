<?php
namespace app\kit\core;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use app\kit\behaviors\PropertyBehavior;

class BaseModel extends ActiveRecord
{

    protected $_map_cache_key = false;

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
            return $this->update(false);
        }
        return parent::delete();
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


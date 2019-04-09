<?php
namespace app\kit\core;

use yii\base\DynamicModel;
use app\kit\helpers\KitHelper;
use yii\base\Model;

/**
 *
 * @author dungang
 */
abstract class BaseDynamicModel extends DynamicModel
{

    private $_dynamic_properties;

    private $__rules = [];

    private $__labels = [];

    private $__hints = [];

    public function init()
    {
        parent::init();
        $this->_dynamic_properties = $this->prepareDynmicProperties();
        $this->prepareRulesAndLabelsAndHints();
    }

    public function getDynamicProperties()
    {
        return $this->_dynamic_properties;
    }

    protected function addDynamicRule($rule)
    {
        $this->__rules[] = $rule;
    }

    protected function addDynamicLabel($attribute, $label)
    {
        $this->__labels[$attribute] = $label;
    }

    protected function addDynamicHint($attribute, $hint)
    {
        $this->__hints[$attribute] = $hint;
    }

    /**
     * 准备已经设置好的动态属性
     */
    protected abstract function prepareDynmicProperties();

    /**
     * 准备好动态属性后，准备标签，验证规则，和提示语
     */
    protected abstract function prepareRulesAndLabelsAndHints();

    /**
     * 准备动态属性的值的保存模型的字段，为批量插入和更新做准备
     *
     * @return array
     */
    protected abstract function prepareExtPropertyValueFields();

    /**
     * 准备保存动态属性子的表
     *
     * @return string
     */
    protected abstract function prepareExtPropertyValueTable();

    /**
     * 准备如何组装好批量查的每行的值
     *
     * @param Model $masterModel
     * @param Model $propertyModel
     * @return array
     */
    protected abstract function prepareExtPropertyValueRow($masterModel, $propertyModel);

    /**
     * 准备模型初始化的动态属性的默认值
     *
     * @param Model $model
     */
    protected abstract function prepareExtPropertyValues($model);

    /**
     * 保存动态属性的值
     *
     * @param Model $masterModel
     */
    protected function saveExtProperites($masterModel)
    {
        $rows = [];
        foreach ($this->_dynamic_properties as $property) {
            $rows[] = $this->prepareExtPropertyValueRow($masterModel, $property);
        }
        if(count($rows)>0){
            KitHelper::batchReplaceInto($this->prepareExtPropertyValueTable(), $this->prepareExtPropertyValueFields(), $rows);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return $this->__labels;
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        return $this->__rules;
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Model::attributeHints()
     */
    public function attributeHints()
    {
        return $this->__hints;
    }
}


<?php

namespace DuAdmin\Validators;

use Yii;
use yii\validators\Validator;
use yii\base\Model;

class SlugValidator extends Validator
{

    public $slugModelClass;

    public $slugFilter = ['id' => 'id'];

    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $filter = $this->modelFilter($model);
        $modelClass = $this->getModelClass($model);
        $query = $modelClass::find()->where(['slug' => $value]);
        if ($this->isUpdate($model)) {
            foreach ($filter as $field => $val) {
                $query->andWhere(['<>', $field, $val]);
            }
        }
        if ($query->count() > 0 ) {
            $model->addError($attribute, Yii::t('yii', '{attribute} "{value}" has already been taken.'));
        }
    }

    /**
     * @param Model $model the data model to be validated
     * @return string Target class name
     */
    private function getModelClass($model)
    {
        return $this->slugModelClass === null ? get_class($model) : $this->slugModelClass;
    }

    public function isUpdate($model)
    {
        foreach (array_keys($this->slugFilter) as $key) {
            if (empty($model->$key)) {
                continue;
            } else {
                return true;
            }
        }
        return false;
    }

    public function modelFilter($model)
    {
        $filter = [];
        foreach ($this->slugFilter as $key => $modelField) {
            $filter[$modelField] = $model[$key];
        }
        return $filter;
    }
}

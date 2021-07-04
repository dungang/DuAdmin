<?php

namespace DuAdmin\Core;

use DuAdmin\Behaviors\PropertyBehavior;
use DuAdmin\Mysql\ActiveRecord;
use Exception;
use JsonSerializable;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class BaseModel extends ActiveRecord implements JsonSerializable {

    /**
     * 对象json序列化的时候设置不显示的字段
     * 隐藏的字段
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

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Model::formName()
     */
    public function formName() {

        return '';
    }

    /**
     * 将模型对象序列化为json字符串
     *
     * {@inheritdoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize() {

        $ary = null;
        if ( empty( $this->jsonHideFields ) ) {
            $ary = $this->toArray( [], $this->extraFields() );
        } else {
            $ary = array_filter( $this->toArray( [], $this->extraFields() ), function ( $key ) {
                return in_array( $key, $this->jsonHideFields ) == false;
            }, ARRAY_FILTER_USE_KEY );
        }
        if ( $this->jsonFields ) {
            foreach ( $this->jsonFields as $field ) {
                if ( isset( $ary [ $field ] ) ) {
                    try {
                        $ary [ $field ] = Json::decode( $ary [ $field ] );
                    } catch ( Exception $ex ) {
                        Yii::error( 'field:' . $field . ' json decode exception.' . $ex->getMessage() );
                        $ary [ $field ] = null;
                    }
                }
            }
        }
        return $ary;
    }

    public function init() {

        parent::init();
        // 是否有软删除字段, 如果有则初始化为0
        if ( $this->hasDeleteProperty() ) {
            $this->isDel = 0;
        }
    }

    public function behaviors() {

        return [
            PropertyBehavior::class
        ];
    }

    /**
     * Sets the attribute values in a massive way.
     *
     * @param array $values
     *          attribute values (name => value) to be assigned to the model.
     * @param bool $safeOnly
     *          whether the assignments should only be done to the safe attributes.
     *          A safe attribute is one that is associated with a validation rule in the current [[scenario]].
     * @see safeAttributes()
     * @see attributes()
     */
    public function setAttributes( $values, $safeOnly = true ) {

        if ( is_array( $values ) ) {
            $attributes = array_flip( $safeOnly ? $this->safeAttributes() : $this->attributes() );
            foreach ( $values as $name => $value ) {
                if ( isset( $attributes [ $name ] ) ) {
                    $this->$name = $value;
                } elseif ( $safeOnly ) {
                    $this->onUnsafeAttribute( $name, $value );
                }
            }
        }
    }

//    /**
//     * 默认开启所有操作的事务
//     */
//    public function transactions() {
//
//        return [
//            static::SCENARIO_DEFAULT => static::OP_ALL
//        ];
//    }

    /**
     * 不是物理删除，而是状态删除
     * 通知isDel字段来标记
     *
     * @return boolean
     */
    protected function hasDeleteProperty() {

        return $this->hasProperty( "isDel" );
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\db\ActiveRecord::delete()
     */
    public function delete() {

        if ( $this->hasDeleteProperty() ) {
            $this->isDel = 1;
            $result = $this->update( false );
            return $result;
        }
        return parent::delete();
    }

    /**
     * 获取去除namespace的类名
     *
     * @return mixed
     */
    public static function getClassShortName() {

        return array_pop( explode( "\\", get_called_class() ) );
    }

    /**
     * 生成map的快捷方法
     *
     * @param string $key
     * @param string $val
     * @param array $where
     * @param array $orderBy
     * @return array|mixed|array|\yii\db\ActiveRecord[]
     */
    public static function allIdToName( $key = 'id', $val = 'name', $where = null, $orderBy = null ) {

        $models = self::find()->select( "$key,$val" )->where( $where )->orderBy( $orderBy )->asArray()->all();
        if ( is_array( $models ) ) {
            return ArrayHelper::map( $models, $key, $val );
        }
        return $models;
    }

}

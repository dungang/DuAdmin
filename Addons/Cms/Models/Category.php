<?php

namespace Addons\Cms\Models;

use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 * "{{%post_category}}"表的模型类.
 *
 * @property int $id
 * @property int $pid 父类
 * @property string $slug Slug
 * @property string $name 分类名称
 * @property string $template 模板
 * @property string $intro 说明
 * @property int $sort 排序
 */
class Category extends \DuAdmin\Core\BaseModel {

  // /**
  // * 对象json序列化的时候设置不显示的字段
  // *
  // * @var array
  // */
  // public $jsonHideFields = [];
  /**
   *
   * {@inheritdoc}
   */
  public static function tableName() {

    return '{{%post_category}}';

  }

  /**
   *
   * {@inheritdoc}
   */
  public function rules() {

    return [
        [
            [
                'pid',
                'sort' ],
            'integer' ],
        [
            [
                'slug',
                'name',
                'template' ],
            'string',
            'max' => 64 ],
        [
            [
                'intro' ],
            'string',
            'max' => 255 ],
        [
            [
                'slug' ],
            'unique' ] ];

  }

  /**
   *
   * {@inheritdoc}
   */
  public function attributeLabels() {

    return [
        'id' => Yii::t( 'da_post_category', 'ID' ),
        'pid' => Yii::t( 'da_post_category', 'Pid' ),
        'slug' => Yii::t( 'da_post_category', 'Slug' ),
        'name' => Yii::t( 'da_post_category', 'Name' ),
        'template' => Yii::t( 'da_post_category', 'Template' ),
        'intro' => Yii::t( 'da_post_category', 'Intro' ),
        'sort' => Yii::t( 'da_post_category', 'Sort' ) ];

  }

  /**
   *
   * {@inheritdoc}
   * @return CategoryQuery the active query used by this AR class.
   */
  public static function find() {

    return new CategoryQuery( get_called_class() );

  }

  public static function getMapWidthDep() {

    return AppHelper::dbQueryAsMapLikeTree( self::tableName(), 'name', null, 'id', 'pid', 0, 1, 'da_cms' );

  }

  /**
   * 父级分类
   *
   * @return \yii\db\ActiveQuery
   */
  public function getParent() {

    return $this->hasOne( Category::class, [
        'id' => 'pid' ] );

  }
}

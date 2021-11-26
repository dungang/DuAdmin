<?php

namespace DuAdmin\Components;

use DuAdmin\Helpers\AppHelper;
use DuAdmin\Storage\IDriver;
use yii\base\BaseObject;
use yii\base\DynamicModel;
use yii\web\UploadedFile;

/**
 *
 * @author dungang
 */
class FileUploader extends BaseObject {

  public $model;

  /**
   * 是否覆写原来的路径
   *
   * @var bool
   */
  public $overwrite = false;

  /**
   * 上传图片的字段
   *
   * @var string
   */
  public $field = 'pic';

  public $file_type = 'image';

  public $file_path = null;

  /**
   * 文件的最大大小
   *
   * @var string
   */
  public $file_max_size = 0;

  /**
   * 如果裁剪，后处理图片
   * 原图处理宽度，如果为空，不处理
   * 实际上是不保留原图，使用默认的缩略图作为原图
   *
   * @var int
   */
  public $width = null;

  /**
   * 如果裁剪，后处理图片
   * 原图处理高度，如果为空，不处理
   * 实际上是不保留原图，使用默认的缩略图作为原图
   *
   * @var int
   */
  public $height = null;

  /**
   * 裁剪图片宽度，文件最终宽度有 width 属性决定
   *
   * @var number
   */
  public $crop_width = null;

  /**
   * 裁剪图片高度，文件最终高度有 heightwidth 属性决定
   *
   * @var number
   */
  public $crop_height = null;

  /**
   * 如果是crop ,坐标X
   *
   * @var string
   */
  public $x = null;

  // 如果是crop ,坐标y
  public $y = null;

  /**
   * 原图切图模式
   * 实际上是不保留原图，使用默认的缩略图作为原图
   *
   * @var string
   */
  public $mode = 'outbound';

  /**
   * 除默认图片之外的缩略图的默认处理模式
   *
   * @var string
   */
  public $thumb_mode = 'outbound';

  /**
   * 缩略图
   * 除默认图片之外的缩略图集合,suffix默认是'_thumb.png'
   * [['width'=>100,'mode'=>'outbound','suffix'=>'_thumb.png'],
   * ['width'=>100,'height'=>100,'mode'=>'outbound','suffix'=>'_100.png'],
   * ['height'=>200,'mode'=>'outbound','suffix'=>'_200.png'],]
   *
   * @var null|array
   */
  public $thumbnails = null;

  /**
   * 存储驱动
   *
   * @var \DuAdmin\Storage\IDriver
   */
  protected static $driver;

  /**
   *
   * @var \yii\web\UploadedFile[] | \yii\web\UploadedFile
   */
  private $_file;

  private $_errors;

  public function init() {

    static::getUploadInstance();

  }

  /**
   * 获取上传驱动组件
   *
   * @return \DuAdmin\Storage\IDriver
   */
  public static function getUploadInstance() {

    if ( empty( self::$driver ) ) {
      $driverName = AppHelper::getSetting( 'system.storage.driver' );
      if ( empty( $driverName ) || $driverName == 'local' ) {
        $class = '\DuAdmin\Storage\LocalDriver';
      } else {
        $class = $driverName;
      }
      self::$driver = \Yii::createObject( $class );
    }
    return self::$driver;

  }

  /**
   * 获取覆写的路径
   *
   * @return string|NULL
   */
  protected function getOverwriteFilePath() {

    if ( $this->overwrite ) {
      if ( $this->model && ! empty( $this->model->{$this->field} ) ) {
        return $this->model->{$this->field};
      }
    } else if ( $this->file_path ) {
      return $this->file_path;
    }
    return null;

  }

  protected function getThumbnailData() {

    if ( is_array( $this->thumbnails ) ) {
      $this->thumbnails = \array_map( function ( $thumbnail ) {
        return \array_merge( [
            'width' => null,
            'height' => null,
            'suffix' => '_thumb.png',
            'mode' => $this->thumb_mode
        ], $thumbnail );
      }, $this->thumbnails );
      return true;
    }
    return false;

  }

  /**
   * 生成缩略图
   *
   * @param string $filePath
   * @param \yii\web\UploadedFile $file
   */
  protected function createThumbnails( $filePath, $file ) {

    $source = IDriver::THUMBNAIL_FROM_TMP;
    if ( $this->x && $this->y ) {
      $source = IDriver::THUMBNAIL_FROM_TARGET;
    }
    foreach ( $this->thumbnails as $thumbnail ) {
      self::$driver->thumbnail( $source, $filePath, $file, $thumbnail ['suffix'], $thumbnail ['width'], $thumbnail ['height'], $thumbnail ['mode'] );
    }

  }

  protected function getResize() {

    if ( empty( $this->width ) && empty( $this->height ) ) {
      return null;
    }
    return [
        'width' => $this->width,
        'height' => $this->height,
        'crop_width' => $this->crop_width,
        'crop_height' => $this->crop_height,
        'x' => $this->x,
        'y' => $this->y,
        'mode' => $this->mode
    ];

  }

  /**
   * 捕获上传的文件
   */
  public function fetchFile() {

    if ( $this->model ) {
      $this->_file = UploadedFile::getInstance( $this->model, $this->field );
    } else {
      $this->_file = UploadedFile::getInstanceByName( $this->field );
    }
    return $this;

  }

  public function fetchFiles() {

    if ( $this->model ) {
      $this->_file = UploadedFile::getInstances( $this->model, $this->field );
    } else {
      $this->_file = UploadedFile::getInstancesByName( $this->field );
    }
    return $this;

  }

  /**
   * 创建动态表单验证
   */
  public function validate( $rule ) {

    \array_unshift( $rule, $this->field, 'file' );
    $model = DynamicModel::validateData( [
        $this->field => $this->_file
    ], [
        $rule
    ] );
    if ( $model->hasErrors( $this->field ) ) {
      $this->_errors = $model->getErrors( $this->field );
      return false;
    }
    return true;

  }

  public function getErrors() {

    return $this->_errors;

  }

  public function getFirstError() {

    if ( count( $this->_errors ) > 0 ) {
      return $this->_errors [0];
    }

  }

  public function upload() {

    if ( empty( $this->_file ) ) {
      $this->fetchFile();
    }
    return $this->uploadFile( $this->_file );

  }

  public function uploads() {

    if ( empty( $this->_file ) ) {
      $this->fetchFiles();
    }
    return $this->uploadFiles( $this->_file );

  }

  /**
   *
   * @param \yii\web\UploadedFile $file
   * @return NULL[]|string[]
   */
  public function uploadFile( $file ) {

    if ( $file ) {
      $filePath = self::$driver->write( $file, $this->file_type, $this->getOverwriteFilePath(), $this->getResize() );
      if ( $this->getThumbnailData() ) {
        $this->createThumbnails( $filePath, $file );
      }
      return [
          'name' => $file->name,
          'url' => self::$driver->getUrl( $filePath ),
          'extension' => $file->extension,
          'size' => $file->size,
          'type' => $file->type,
          'tempName' => $file->tempName
      ];
    }
    return null;

  }

  /**
   *
   * @param \yii\web\UploadedFile[] $files
   * @return NULL[][]|string[][]
   */
  public function uploadFiles( $files ) {

    $results = [ ];
    if ( $files ) {
      foreach ( $files as $file ) {
        $results [] = $this->uploadFile( $file );
      }
    }
    return $results;

  }
}

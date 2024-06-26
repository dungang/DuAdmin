<?php

namespace DuAdmin\Uploader;

use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;

/**
 * 上传文件模型
 *
 * @author dungang
 *
 */
class UploadForm extends Model
{

  public $key;

  /**
   * @var \yii\web\UploadedFile|string $file
   */
  public $file;

  public function rules()
  {

    $extensions = AppHelper::getSetting('system.storage.extensions');
    $extensions = empty($extensions) ? 'jpg,jpeg,png' : $extensions;
    return [
      [
        [
          'key',
          'file'
        ],
        'required'
      ],
      [
        [
          'key'
        ],
        'string'
      ],
      [
        [
          'file'
        ],
        'file',
        'skipOnEmpty' => false,
        'checkExtensionByMimeType' => false,
        'extensions' => $extensions
      ]
    ];
  }

  public function upload()
  {

    \Yii::$app->response->format = 'json';
    if ($this->validate()) {
      $key = trim($this->key, '.');
      if (strpos($key, '..') === false) {
        $dist = \Yii::getAlias("@webroot/" . $key);
        $distDir = dirname($dist);
        if (!is_dir($distDir)) {
          FileHelper::createDirectory($distDir);
        }
        try {
          $this->file->saveAs($dist);
          return [
            'name' => $this->file->name,
            "url" => $key
          ];
        } catch (\Exception $ex) {
          \Yii::error($ex->getMessage());
        }
        return null;
      } else {
        throw new BadRequestHttpException();
      }
    } else {
      throw new BizException(array_values($this->firstErrors)[0]);
    }
  }
}

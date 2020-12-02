<?php
namespace DuAdmin\Uploader;

use DuAdmin\Components\ApiActionChain;
use DuAdmin\Helpers\MAHelper;
use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;

/**
 * 上传图片和文件
 */
class LocalUploadAction extends Action
{

    public function run()
    {
        $allow_extensions = MAHelper::getSettingAry('uploader.allow_extensions');

        return ApiActionChain::getInstance()->mustPost()
            ->setFields([
            'key' => Yii::t('ma', 'Save Key'),
            'file' => Yii::t('ma', 'File')
        ])
            ->setFieldsRules([
            [
                [
                    'key'
                ],
                'required'
            ],
            [
                'key',
                'string'
            ],
            [
                [
                    'file'
                ],
                'file',
                'extensions' => $allow_extensions
            ]
        ])
            ->done(function ($params, $model) {
            $key = trim($model->key, '.');
            if (strpos($key, '..') === false) {
                $dist = \Yii::getAlias("@app/public/uploads/" . $key);
                $distDir = dirname($dist);
                if (! is_dir($distDir)) {
                    FileHelper::createDirectory($distDir);
                }
                try {
                    $file = UploadedFile::getInstanceByName('file');
                    $file->saveAs($dist);
                    return json_encode([
                        "url" => $key
                    ]);
                } catch (\Exception $ex) {
                    \Yii::error($ex->getMessage());
                }
                return null;
            } else {
                throw new BadRequestHttpException();
            }
        });
    }
}

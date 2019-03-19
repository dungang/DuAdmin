<?php
namespace app\kit\forms;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\base\Exception;

/**
 *
 * @author dungang
 *        
 */
abstract class ImportFileForm extends Model
{

    public $file;

    public $extensions = 'txt';

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Model::attributeLabels()
     */
    public function attributeLabels()
    {
        return [
            'file' => '文件'
        ];
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        return [
            [
                'file',
                'required'
            ],
            [
                'file',
                'file',
                'skipOnEmpty' => false,
                'extensions' => $this->extensions
            ]
        ];
    }

    /**
     * 处理文件的内容，并准备好数据
     *
     * @param string $content
     *            文件内容
     * @return mixed
     */
    protected abstract function prepareData($content);

    /**
     * 处理准备的数据
     *
     * @param mixed $data
     * @return boolean|int
     */
    protected abstract function processData($data);

    protected function toLines($content)
    {
        return \explode("\n", trim($content));
    }

    protected function toBigJson($content)
    {
        return Json::decode($content);
    }

    public function save($validate = true)
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        if ($validate && ! $this->validate()) {
            return false;
        }
        if ($content = \file_get_contents($this->file->tempName)) {
            if ($data = $this->prepareData($content)) {
                $rst = \Yii::$app->db->transaction(function ($db) use ($data) {
                    return $this->processData($data);
                });
                if ($rst)
                    return true;
                else
                    throw new Exception('保存数据失败');
            }
            throw new Exception('文件内容格式不正确');
        }
        throw new Exception('文件上传失败');
    }
}


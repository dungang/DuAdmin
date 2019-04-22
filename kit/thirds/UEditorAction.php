<?php
namespace app\kit\thirds;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use app\kit\components\FileUploader;

class UEditorAction extends Action
{

    /**
     *
     * @var array
     */
    public $config = [];

    public function init()
    {
        parent::init();
        // close csrf
        Yii::$app->request->enableCsrfValidation = false;
        // 默认设置
        $_config = require (__DIR__ . '/../config/config.php');
        // load config file
        $this->config = ArrayHelper::merge($_config, $this->config);
    }

    /**
     * 处理action
     */
    public function run()
    {
        $action = Yii::$app->request->get('action');
        switch ($action) {
            case 'config':
                $result = json_encode($this->config);
                break;
            /* 上传图片 */
            case 'uploadimage':
            /* 上传视频 */
            case 'uploadvideo':
            /* 上传文件 */
            case 'uploadfile':
                $result = $this->actionUpload();
                break;
            /* 列出图片 */
            case 'listimage':
            /* 列出文件 */
            case 'listfile':
                $result = $this->actionList();
                break;
            default:
                $result = json_encode(array(
                    'state' => '请求地址出错'
                ));
                break;
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                return htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                return json_encode(array(
                    'state' => 'callback参数不合法'
                ));
            }
        } else {
            return $result;
        }
    }

    /**
     * 上传
     *
     * @return string
     */
    protected function actionUpload()
    {
        $pass = true;
        switch (htmlspecialchars($_GET['action'])) {
            case 'uploadimage':
                $uploader = new FileUploader([
                    'file_type' => 'image',
                    'field' => $this->config['imageFieldName']
                ]);
                $pass = $uploader->file()->validate([
                    'skipOnEmpty'=>false,
                    'extensions'=> $this->reAccept($this->config['imageAllowFiles']),
                    'maxSize' => $this->config['imageMaxSize']
                ]);
                break;
            case 'uploadvideo':
                
                $uploader = new FileUploader([
                'file_type' => 'video',
                'field' => $this->config['videoFieldName']
                ]);
                $pass = $uploader->file()->validate([
                    'skipOnEmpty'=>false,
                    'extensions'=> $this->reAccept($this->config['videoAllowFiles']),
                    'maxSize' => $this->config['videoMaxSize']
                ]);
                break;
            default:
                $uploader = new FileUploader([
                'file_type' => 'file',
                'field' => $this->config['fileFieldName']
                ]);
                $pass = $uploader->file()->validate([
                    'skipOnEmpty'=>false,
                    'extensions'=> $this->reAccept($this->config['fileAllowFiles']),
                    'maxSize' => $this->config['fileMaxSize']
                ]);
        }
        if($pass == false){
            $rst = ['erro'=>$uploader->getErrors()];
        } else {
            $rst = $uploader->upload();
        }
        return $this->response($rst);
    }

    /**
     * 获取已上传的文件列表
     *
     * @return string
     */
    protected function actionList()
    {
        return json_encode([]);
    }

    /**
     * 获取当前上传成功文件的各项信息
     *
     * @param  $rst
     * @return array
     */
    public function response($rst)
    {
        $result = [];
        if ($rst->isCompleted) {
            $result['url'] = $rst['url'];
            $result['title'] = $rst->name;
            $result['original'] = $rst->originName;
            $result['type'] = '.' . $rst->extension;
            $result['size'] = $rst->size;
        }
        if ($rst->isOk) {
            $result['state'] = 'SUCCESS';
        } else {
            $result['state'] = $rst['error'];
        }

        return json_encode($result);
    }

    public function reAccept($allow)
    {
        return array_map(function ($val) {
            return ltrim($val, '.');
        }, $allow);
    }
}


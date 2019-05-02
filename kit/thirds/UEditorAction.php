<?php
namespace app\kit\thirds;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use app\kit\components\FileUploader;
use yii\helpers\Json;

/**
 * 百度编辑器文件上传action
 */
class UEditorAction extends Action
{

    /**
     * 本次请求的配置项目
     * @var array
     */
    public $config = [];

    public function init()
    {
        parent::init();
        // close csrf
        Yii::$app->request->enableCsrfValidation = false;
        // 默认设置
        $_config = $this->getDefaultConfig();
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
                $result = Json::encode($this->config);
                break;
                /* 上传图片 */
            case 'uploadimage':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = $this->actionUpload();
                break;
            default:
                $result = Json::encode(array(
                    'state' => '不知支持此功能！'
                ));
                break;
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                return htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                return Json::encode(array(
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
                $pass = $uploader->fetchFile()->validate([
                    'skipOnEmpty' => false,
                    'extensions' => $this->reAccept($this->config['imageAllowFiles']),
                    'maxSize' => $this->config['imageMaxSize']
                ]);
                break;
            case 'uploadvideo':
                $uploader = new FileUploader([
                    'file_type' => 'video',
                    'field' => $this->config['videoFieldName']
                ]);
                $pass = $uploader->fetchFile()->validate([
                    'skipOnEmpty' => false,
                    'extensions' => $this->reAccept($this->config['videoAllowFiles']),
                    'maxSize' => $this->config['videoMaxSize']
                ]);
                break;
            default:
                $uploader = new FileUploader([
                    'file_type' => 'file',
                    'field' => $this->config['fileFieldName']
                ]);
                $pass = $uploader->fetchFile()->validate([
                    'skipOnEmpty' => false,
                    'extensions' => $this->reAccept($this->config['fileAllowFiles']),
                    'maxSize' => $this->config['fileMaxSize']
                ]);
        }
        if ($pass == false) {
            $rst = ['erro' => $uploader->getErrors()];
        } else {
            $rst = $uploader->upload();
        }
        return $this->response($rst);
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
        if (isset($rst['erro'])) {
            $result['state'] = $rst['error'];
        } else {
            $result['url'] = $rst['url'];
            $result['title'] = $rst['name'];
            $result['original'] = $rst['name'];
            $result['type'] = '.' . $rst['extension'];
            $result['size'] = $rst['size'];
            $result['state'] = 'SUCCESS';
        }

        return Json::encode($result);
    }

    public function reAccept($allow)
    {
        return array_map(function ($val) {
            return ltrim($val, '.');
        }, $allow);
    }

    public function getDefaultConfig()
    {
        return [
            /* 上传图片配置项 */
            "imageActionName"         => "uploadimage",
            /* 执行上传图片的action名称 */
            "imageFieldName"          => "upfile",
            /* 提交的图片表单名称 */
            "imageMaxSize"            => 2048000,
            /* 上传大小限制，单位B */
            "imageAllowFiles"         => [
                ".png",
                ".jpg",
                ".jpeg",
                ".gif",
                ".bmp"
            ],
            /* 上传图片格式显示 */
            "imageCompressEnable"     => true,
            /* 是否压缩图片,默认是true */
            "imageCompressBorder"     => 1600,
            /* 图片压缩最长边限制 */
            "imageInsertAlign"        => "none",
            /* 插入的图片浮动方式 */
            "imageUrlPrefix"          => "",
            /* 图片访问路径前缀 */
            //"imagePathFormat"         => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            /* 上传保存路径,可以自定义保存路径和文件名格式 */
            /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
            /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
            /* {time} 会替换成时间戳 */
            /* {yyyy} 会替换成四位年份 */
            /* {yy} 会替换成两位年份 */
            /* {mm} 会替换成两位月份 */
            /* {dd} 会替换成两位日期 */
            /* {hh} 会替换成两位小时 */
            /* {ii} 会替换成两位分钟 */
            /* {ss} 会替换成两位秒 */
            /* 非法字符 \ => * ? " < > | */
            /* 具请体看线上文档=> fex.baidu.com/ueditor/#use-format_upload_filename */

            /* 涂鸦图片上传配置项 */
            "scrawlActionName"        => "uploadscrawl",
            /* 执行上传涂鸦的action名称 */
            "scrawlFieldName"         => "upfile",
            /* 提交的图片表单名称 */
            //"scrawlPathFormat"        => "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "scrawlMaxSize"           => 2048000,
            /* 上传大小限制，单位B */
            "scrawlUrlPrefix"         => "",
            /* 图片访问路径前缀 */
            "scrawlInsertAlign"       => "none",
            /* 截图工具上传 */
            "snapscreenActionName"    => "uploadimage",
            /* 执行上传截图的action名称 */
            //"snapscreenPathFormat"    => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "snapscreenUrlPrefix"     => "",
            /* 图片访问路径前缀 */
            "snapscreenInsertAlign"   => "none",
            /* 插入的图片浮动方式 */

            /* 抓取远程图片配置 */
            "catcherLocalDomain"      => [
                "127.0.0.1",
                "localhost",
                "img.baidu.com"
            ],
            "catcherActionName"       => "catchimage",
            /* 执行抓取远程图片的action名称 */
            "catcherFieldName"        => "source",
            /* 提交的图片列表表单名称 */
            //"catcherPathFormat"       => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "catcherUrlPrefix"        => "",
            /* 图片访问路径前缀 */
            "catcherMaxSize"          => 2048000,
            /* 上传大小限制，单位B */
            "catcherAllowFiles"       => [
                ".png",
                ".jpg",
                ".jpeg",
                ".gif",
                ".bmp"
            ],
            /* 抓取图片格式显示 */

            /* 上传视频配置 */
            "videoActionName"         => "uploadvideo",
            /* 执行上传视频的action名称 */
            "videoFieldName"          => "upfile",
            /* 提交的视频表单名称 */
            //"videoPathFormat"         => "/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}",
            /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "videoUrlPrefix"          => "",
            /* 视频访问路径前缀 */
            "videoMaxSize"            => 102400000,
            /* 上传大小限制，单位B，默认100MB */
            "videoAllowFiles"         => [
                ".flv",
                ".swf",
                ".mkv",
                ".avi",
                ".rm",
                ".rmvb",
                ".mpeg",
                ".mpg",
                ".ogg",
                ".ogv",
                ".mov",
                ".wmv",
                ".mp4",
                ".webm",
                ".mp3",
                ".wav",
                ".mid"
            ],
            /* 上传视频格式显示 */

            /* 上传文件配置 */
            "fileActionName"          => "uploadfile",
            /* controller里,执行上传视频的action名称 */
            "fileFieldName"           => "upfile",
            /* 提交的文件表单名称 */
            //"filePathFormat"          => "/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}",
            /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "fileUrlPrefix"           => "",
            /* 文件访问路径前缀 */
            "fileMaxSize"             => 51200000,
            /* 上传大小限制，单位B，默认50MB */
            "fileAllowFiles"          => [
                ".png",
                ".jpg",
                ".jpeg",
                ".gif",
                ".bmp",
                ".flv",
                ".swf",
                ".mkv",
                ".avi",
                ".rm",
                ".rmvb",
                ".mpeg",
                ".mpg",
                ".ogg",
                ".ogv",
                ".mov",
                ".wmv",
                ".mp4",
                ".webm",
                ".mp3",
                ".wav",
                ".mid",
                ".rar",
                ".zip",
                ".tar",
                ".gz",
                ".7z",
                ".bz2",
                ".cab",
                ".iso",
                ".doc",
                ".docx",
                ".xls",
                ".xlsx",
                ".ppt",
                ".pptx",
                ".pdf",
                ".txt",
                ".md",
                ".xml"
            ],
            /* 上传文件格式显示 */

            /* 列出指定目录下的图片 */
            "imageManagerActionName"  => "listimage",
            /* 执行图片管理的action名称 */
            //"imageManagerListPath"    => "/upload/image/",
            /* 指定要列出图片的目录 */
            "imageManagerListSize"    => 20,
            /* 每次列出文件数量 */
            "imageManagerUrlPrefix"   => "",
            /* 图片访问路径前缀 */
            "imageManagerInsertAlign" => "none",
            /* 插入的图片浮动方式 */
            "imageManagerAllowFiles"  => [
                ".png",
                ".jpg",
                ".jpeg",
                ".gif",
                ".bmp"
            ],
            /* 列出的文件类型 */

            /* 列出指定目录下的文件 */
            "fileManagerActionName"   => "listfile",
            /* 执行文件管理的action名称 */
            //"fileManagerListPath"     => "/upload/file/",
            /* 指定要列出文件的目录 */
            "fileManagerUrlPrefix"    => "",
            /* 文件访问路径前缀 */
            "fileManagerListSize"     => 20,
            /* 每次列出文件数量 */
            "fileManagerAllowFiles"   => [
                ".png",
                ".jpg",
                ".jpeg",
                ".gif",
                ".bmp",
                ".flv",
                ".swf",
                ".mkv",
                ".avi",
                ".rm",
                ".rmvb",
                ".mpeg",
                ".mpg",
                ".ogg",
                ".ogv",
                ".mov",
                ".wmv",
                ".mp4",
                ".webm",
                ".mp3",
                ".wav",
                ".mid",
                ".rar",
                ".zip",
                ".tar",
                ".gz",
                ".7z",
                ".bz2",
                ".cab",
                ".iso",
                ".doc",
                ".docx",
                ".xls",
                ".xlsx",
                ".ppt",
                ".pptx",
                ".pdf",
                ".txt",
                ".md",
                ".xml"
            ]
            /* 列出的文件类型 */
        ];
    }
}

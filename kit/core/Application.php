<?php

namespace app\kit\core;

use Yii;
use yii\validators\Validator;
use yii\web\Application as WebApplication;

class Application extends WebApplication
{

    const MODE_BACKEND = 'backend';
    const MODE_FRONTEND = 'frontend';
    const MODE_API = 'api';
    public $mode = 'frontend';
    public $validators = [];

    public function init()
    {
        parent::init();

        //更加参数识别语言
        //需要 \app\kit\components\RewriteUrl的支持
        if ($lang = Yii::$app->request->get('lang')) {
            Yii::$app->urlManager->common_params['lang'] = $lang;
            $this->language = $lang;
        } else {
            // 根据浏览器识别语言
            if (($accept_langs = Yii::$app->request->acceptableLanguages) &&
                is_array($accept_langs) &&
                count($accept_langs) > 0
            ) {
                $this->language = Yii::$app->request->acceptableLanguages[0];
            }
        }
        //注册自定义的验证器
        foreach ($this->validators as $name => $validator) {
            Validator::$builtInValidators[$name] = $validator;
        }
    }

    public function isBackend()
    {
        return $this->mode === static::MODE_BACKEND;
    }

    public function isFrontend()
    {
        return $this->mode === static::MODE_FRONTEND;
    }

    public function isApi()
    {
        return $this->mode === static::MODE_API;
    }
}

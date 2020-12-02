<?php

namespace DuAdmin\Core;

use DuAdmin\Helpers\MAHelper;
use yii\helpers\Url;
use yii\validators\Validator;
use yii\web\Application as WebApplication;

class Application extends WebApplication
{

    const MODE_BACKEND = 'Backend';

    const MODE_FRONTEND = 'Frontend';

    const MODE_API = 'Api';

    public $mode = 'Frontend';

    public $jwtSecret = 'jwt-secret-key';

    public $validators = [];

    public function init()
    {
        if(defined('RUNTIME_MODE')) {
            $this->mode = RUNTIME_MODE;
        }
        parent::init();
        
        MAHelper::swtichLanguage();
        //注册自定义的验证器
        foreach ($this->validators as $name => $validator) {
            Validator::$builtInValidators[$name] = $validator;
        }
    }

    public function getHomeUrl()
    {
        //$url = parent::getHomeUrl();

        return  Url::to(['/']);
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

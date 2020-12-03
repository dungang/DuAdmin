<?php

namespace DuAdmin\Core;

use DuAdmin\Helpers\AppHelper;
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
        //注册项目别名 ，没有注册 DuAdmin目录，因为有安装scripts,所以使用了composer的autoload
        // 一下文字是引用的来源 https://www.yiichina.com/doc/guide/2.0/concept-autoloading
        // 你也可以只使用 Composer 的自动加载，而不用 Yii 的自动加载。 
        // 不过这样做的话，类的加载效率会下降， 且你必须遵循 Composer 所设定的规则，
        // 从而让你的类满足可以被自动加载的要求。
        \Yii::setAlias("@Addons", $this->basePath . "/Addons");
        \Yii::setAlias("@Backend", $this->basePath . "/Backend");
        \Yii::setAlias("@Frontend", $this->basePath . "/Frontend");
        \Yii::setAlias("@Api", $this->basePath . "/Api");
        \Yii::setAlias("@Console", $this->basePath . "/Console");
        parent::init();
        
        AppHelper::swtichLanguage();
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

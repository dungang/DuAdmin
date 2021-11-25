<?php

namespace DuAdmin\Core;

use DuAdmin\Helpers\AppHelper;
use yii\validators\Validator;
use yii\web\Application as WebApplication;

/**
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-24
 *
 * @property ActionLog $actionLog
 */
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
        if ( defined( 'RUNTIME_MODE' ) ) {
            $this->mode = RUNTIME_MODE;
        }
        parent::init();

        AppHelper::swtichLanguage();
        //注册自定义的验证器
        foreach ( $this->validators as $name => $validator ) {
            Validator::$builtInValidators[ $name ] = $validator;
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

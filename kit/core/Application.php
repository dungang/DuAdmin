<?php

namespace app\kit\core;

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

<?php

namespace app\kit\core;

use yii\web\Application as WebApplication;

class Application extends WebApplication
{

    const MODE_BACKEND = 'backend';
    const MODE_FRONTEND = 'frontend';
    const MODE_API = 'api';
    public $mode = 'frontend';

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

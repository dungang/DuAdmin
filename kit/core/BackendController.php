<?php
namespace app\kit\core;

use app\kit\filters\AccessFilter;
use app\kit\filters\SaveRouteFilter;

abstract class BackendController extends BaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if (YII_ENV_DEV)
            $behaviors['saveRoute'] = SaveRouteFilter::className();
        $behaviors[AccessFilter::ID] = AccessFilter::className();
        return $behaviors;
    }
}


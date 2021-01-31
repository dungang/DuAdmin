<?php

namespace DuAdmin\Core;

use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class ApiController extends Controller
{
    public $hiddenFields;

    /**
     * 不接受验证的actionId
     */
    public $authExceptActions = [];

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'except' => $this->authExceptActions
            ],
            'rateLimiter' => [
                'class' => RateLimiter::class,
            ],
        ];
    }
}

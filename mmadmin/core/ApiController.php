<?php

namespace app\mmadmin\core;

use app\mmadmin\helpers\MAHelper;
use yii\base\Arrayable;
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
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET','POST', 'PUT','OPTIONS','HEAD'],
                ]
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

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        if ($this->hiddenFields && (is_array($result) || $result instanceof Arrayable)) {
            if (is_string($this->hiddenFields)) {
                $fields = explode(',', $this->hiddenFields);
            } else {
                $fields = $this->hiddenFields;
            }
            $result = MAHelper::walkRecursiveRemove($result, function ($v, $k) use ($fields) {
                return in_array($k, $fields);
            });
        }
        return $result;
    }
}

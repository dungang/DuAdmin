<?php

namespace app\frontend\controllers;

use app\mmadmin\swagger\SwaggerApiAction;
use app\mmadmin\swagger\SwaggerDocAction;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class SwaggerController extends Controller
{
    public function actions()
    {
        return [
            //The document preview addesss:http://api.yourhost.com/site/doc
            'doc' => [
                'class' => SwaggerDocAction::className(),
                'restUrl' => Url::to(['/site/api'], true),
            ],
            //The resultUrl action.
            'api' => [
                'class' => SwaggerApiAction::className(),
                //The scan directories, you should use real path there.
                'scanDir' => [
                    Yii::getAlias('@api/modules/v1/swagger'),
                    Yii::getAlias('@api/modules/v1/controllers'),
                    Yii::getAlias('@api/modules/v1/models'),
                    Yii::getAlias('@api/models'),
                ],
                //The security key
                'api_key' => 'balbalbal',
                // 'cache' => 'cache',
                // 'cacheKey' => 'api-swagger-cache'
            ],
        ];
    }
}

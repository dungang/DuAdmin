<?php

namespace DuAdmin\Behaviors;

use Yii;
use yii\base\Arrayable;
use yii\base\Behavior;
use yii\helpers\BaseInflector;
use yii\web\Response;

class ResponseJson extends Behavior
{

    public function events()
    {
        return [
            Response::EVENT_BEFORE_SEND =>  'beforeSend'
        ];
    }

    public function variablize($sourceArray,&$variablizeArray){
        foreach($sourceArray as $key => $val) {
            $key = BaseInflector::variablize($key);
            if(is_array($val) || $val instanceof Arrayable ) {
                if(empty($variablizeArray[$key])) $variablizeArray[$key] = array();
                $this->variablize($val,$variablizeArray[$key]);
            } else {
                $variablizeArray[$key] = $val;
            }
        }
    }

    public function beforeSend($event)
    {
        $response = $event->sender;
        if ($response->data !== null) {
            $data = [
                'success' => $response->isSuccessful,
                'status' => $response->statusCode,
                'message' => '',
                'data' => $response->data,
            ];
            if ($response->statusCode !== 200) {
                $data['message'] = isset($response->data['message']) ? $response->data['message'] : '';
            }
            $variablize = array();
            $this->variablize($data,$variablize);
            $response->data = $variablize;
            $response->statusCode = 200;
        }
    }
}

<?php

namespace DuAdmin\Behaviors;

// use JsonSerializable;
// use Yii;
use yii\base\Arrayable;
use yii\base\Behavior;
use yii\helpers\BaseInflector;
use yii\web\Response;

class ResponseJson extends Behavior
{

    public function events()
    {
        return [
            Response::EVENT_BEFORE_SEND =>  'beforeSend',
            Response::EVENT_AFTER_PREPARE => 'afterPrepare'
        ];
    }

    public function afterPrepare($event) {
        $event->sender->getHeaders()
            ->set('X-Request-Duration', number_format((microtime(true) - YII_BEGIN_TIME) * 1000 + 1));
    }

    public function variablize($sourceArray,&$variablizeArray){
        foreach($sourceArray as $key => $val) {
            $key = BaseInflector::variablize($key);
            // if ($val instanceof JsonSerializable) {
            //     if(empty($variablizeArray[$key])) $variablizeArray[$key] = array();
            //     $this->variablize($val->jsonSerialize(),$variablizeArray[$key]);
            // }  else 
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

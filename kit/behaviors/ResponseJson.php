<?php

namespace app\kit\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Response;

class ResponseJson extends Behavior
{

    public function events()
    {
        return [
            Response::EVENT_BEFORE_SEND =>  'beforeSend'
        ];
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
            $response->data = $data;
            $response->statusCode = 200;
        }
    }
}

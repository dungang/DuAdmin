<?php

namespace DuAdmin\Core;

use yii\web\ErrorAction;

class CustomErrorAction extends ErrorAction
{

    /**
     * 并转成数组的格式
     */
    protected function renderAjaxResponse()
    {
        $content = [
            'status' => 'error',
            'message' => $this->getExceptionMessage()
        ];
        return $content;
    }
}

<?php

namespace app\mmadmin\components;

use yii\web\UrlManager;

class BackendUrlManager extends UrlManager
{
    /**
     * 公共参数
     * 保证每一个url都包含的参数
     * 
     * @var array
     */
    public $common_params = [];

    /**
     * {@inheritDoc}
     * @see \yii\web\UrlManager::createUrl()
     */
    public function createUrl($params)
    {
        if ($this->common_params && \is_array($params)) {
            $params = array_merge($this->common_params, $params);
        }
        return parent::createUrl($params);
    }
}

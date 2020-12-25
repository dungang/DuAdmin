<?php
namespace DuAdmin\Components;

use yii\web\UrlManager;

class DuaUrlManager extends UrlManager
{

    /**
     * 公共参数
     * 保证每一个url都包含的参数
     *
     * @var array
     */
    public $common_params = [];
    
    /**
     * @var string the cache key for cached rules
     * @since 2.0.8
     */
    protected $cacheKey = __CLASS__;

    /**
     *
     * {@inheritdoc}
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

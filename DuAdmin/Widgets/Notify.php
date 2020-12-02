<?php

namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Assets\NotifyAsset;
use yii\helpers\Json;

class Notify extends Widget
{
    /**
     * center left right
     *
     * @var string
     */
    public $position = 'center';

    // public $width;

    // public $height;
    public $autohide = true;

    public $opacity = 1;

    public $multiline = true;

    public $clickable = false;

    public $timeout = 5000;

    //success, error, warning, info
    public $alertTypes = [
        'error' => 'error',
        'danger' => 'error',
        'exception' => 'error',
        'fail' => 'error',
        'success' => 'success',
        'info' => 'info',
        'warning' => 'warning'
    ];


    public function run()
    {
        NotifyAsset::register($this->view);
        $session = \Yii::$app->session;
        $flashes = $session->getAllFlashes();
        // print_r($flashes);
        // die;
        foreach ($flashes as $type => $flash) {
            if (isset($this->alertTypes[$type]) && $type = $this->alertTypes[$type]) {
                foreach (array_values((array) $flash) as $message) {
                    $this->renderNotify($type, $message);
                }
            }
            $session->removeFlash($type);
        }
    }

    public function renderNotify($type, $msg)
    {
        $options = [
            'msg' => $msg,
            'type' => $type,
            'position' => $this->position,
            // 'width'=>$this->width,
            // 'height'=>$this->height,
            'autohide' => $this->autohide,
            'opacity' => $this->opacity,
            'multiline' => $this->multiline,
            'clickable' => $this->clickable,
            'timeout' => $this->timeout
        ];

        $js = "notif(" . Json::htmlEncode($options) . ")";
        $this->view->registerJs($js);
    }
}

<?php
namespace app\kit\core;

use yii\web\View;
use app\kit\models\EventHandler;

/**
 *
 * @author dungang
 */
class CoreView extends View
{

    public function init()
    {
        parent::init();
        if ($handlers = EventHandler::getCacheActiveEventHandlers('View')) {
            foreach ($handlers as $handler) {
                $this->on($handler['event'], [
                    \Yii::createObject($handler['handler']),
                    'process'
                ]);
            }
        }
    }
}


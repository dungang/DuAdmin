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
        EventHandler::registerLevel($this, 'View');
    }
}


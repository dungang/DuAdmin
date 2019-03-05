<?php
namespace app\kit\core;

abstract class FrontendController extends BaseController
{

    public function init()
    {
        parent::init();
        $this->layout = 'front-end';
    }
}


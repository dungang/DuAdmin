<?php
namespace app\kit\core;

abstract class FrontendController extends BaseController
{

    public function init()
    {
        parent::init();
        $this->layout = 'front-end';
    }

//     public function behaviors()
//     {
//         $bs = parent::behaviors();
//         $bs['post_rate_limit'] = 'app\kit\filters\PostRateLimitFilter';
//         return $bs;
//     }
}


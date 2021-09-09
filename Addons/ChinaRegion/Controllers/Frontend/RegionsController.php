<?php
namespace Addons\ChinaRegion\Controllers\Frontend;

use Addons\ChinaRegion\Actions\RegionsAction;
use DuAdmin\Core\FrontendController;

class RegionsController extends FrontendController {

    public function actions()
    {
        return [
            'index' => [
                'class' => RegionsAction::class
            ]
        ];
    }
}
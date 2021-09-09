<?php
namespace Addons\ChinaRegion\Controllers\Backend;

use Addons\ChinaRegion\Actions\RegionsAction;
use DuAdmin\Core\BackendController;

class RegionsController extends BackendController {

    public function actions()
    {
        return [
            'index' => ['class'=>RegionsAction::class]
        ];
    }
}
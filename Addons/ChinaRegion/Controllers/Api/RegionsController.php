<?php
namespace Addons\ChinaRegion\Controllers\Api;

use Addons\ChinaRegion\Models\ChinaRegion;
use DuAdmin\Core\ApiController;
use DuAdmin\Helpers\AppHelper;

class RegionsController extends ApiController {

    public function init()
    {
        $this->authExceptActions = ['*'];
    }

    public function actionIndex(){
        $query = ChinaRegion::find();
        $models = $query->asArray()->all();
        return AppHelper::listToTree($models);
    }

}
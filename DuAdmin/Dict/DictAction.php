<?php
namespace DuAdmin\Dict;

use DuAdmin\Models\DictData;
use yii\base\Action;

class DictAction extends Action {

    public function runWithParams($params)
    {
        return DictData::getDataLabels($params['type']);
    }
}
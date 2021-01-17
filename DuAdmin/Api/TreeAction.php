<?php

namespace DuAdmin\Api;

use DuAdmin\Helpers\AppHelper;

class TreeAction extends BaseAction
{

    public $treeKey = 'id';

    public $treeParent = 'pid';

    public $orderBy = null;

    public function run()
    {
        list($modelClass, $condition) = $this->builderFindModelCondition();
        $query = $modelClass::find()->where($condition);
        if($this->order) {
            $query->orderBy($this->orderBy);
        }
        $models = $query->asArray()->all();
        return AppHelper::listToTree($models,$this->treeKey,$this->treeParent);
    }
}

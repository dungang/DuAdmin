<?php
namespace Console;

use yii\console\Controller;
use DuAdmin\Helpers\AppHelper;

class BaseController extends Controller
{
    
    protected function selectOneAddonName(){
        $addonNames = AppHelper::getAddonNames();
        $idx = $this->select("请输入插件的目录名称,?列出选项", $addonNames);
        if(isset($addonNames[$idx])) {
            return $addonNames[$idx];
        } else {
            return $this->selectOneAddonName();
        }
    }

    protected function mustDevCanDo(){
        if (YII_ENV_PROD) {
            $this->stdout("YII_ENV is set to 'prod'.\nRefreshing migrations is not possible on production systems.\n");
            exit;
        }
    }
}


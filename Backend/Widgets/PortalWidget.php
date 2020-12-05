<?php

namespace Backend\Widgets;

use Backend\Models\Portal;
use Backend\Models\PortalPlace;
use yii\base\Widget;
use Backend\Models\PortalPrivilege;
use DuAdmin\Assets\JqueryUIAsset;
use Yii;

class PortalWidget extends Widget
{
    public function run()
    {
        JqueryUIAsset::register($this->view);
        $roles = array_map(function($role){
            return $role->name;
        },Yii::$app->authManager->getRolesByUser(Yii::$app->user->id));
        
        $privilege = PortalPrivilege::findOne(['role' => $roles]);
        $query = Portal::find()->where(['unlimited' => 1]);
        if ($privilege && $privilege->portals) {
            $query->orWhere(['id' => explode(',', $privilege->portals)]);
        }
        $portals = $query->indexBy('id')->all();

        if ($place = PortalPlace::findOne(['adminId' => \Yii::$app->user->id])) {
            $places = explode(',', $place->portals);
            $portals = array_filter($portals, function ($portal) use ($places) {
                return in_array($portal->id, $places);
            });
        }

        $statics = '';
        $info = '';
        foreach ($portals as $portal) {
            //检查类必须存在，有可能代码移除了，但是数据库的数据没有变化
            if (class_exists($portal->code)) {
                if ($portal->isStatic) {
                    $statics .= call_user_func([$portal->code, 'widget']);
                } else {
                    $info .= call_user_func([$portal->code, 'widget']);
                }
            }
        }
        $this->enableSortable();
        return '<div class="row connectedSortable">' . $statics . '</div>' . '<div class="row connectedSortable">' . $info . '</div>';
    }

    private function enableSortable()
    {
        $this->view->registerJs(";(function(){
            // Make the dashboard widgets sortable Using jquery UI
            $('.connectedSortable').sortable({
              placeholder         : 'sort-highlight',
              connectWith         : '.connectedSortable',
              handle              : '.box-header, .nav-tabs',
              forcePlaceholderSize: true,
              zIndex              : 999999
            });
            $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');
        })();");
    }
}

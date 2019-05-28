<?php

namespace app\backend\widgets;

use yii\base\Widget;
use app\backend\models\PortalPrivilege;
use app\backend\models\Portal;
use app\backend\models\PortalPlace;

class PortalWidget extends Widget
{
    public function run()
    {
        $privilege = PortalPrivilege::findOne(['role' => \Yii::$app->user->identity->role]);
        $query = Portal::find()->where(['unlimited'=>1]);
        if ($privilege && $privilege->portals) {
            $query->orWhere(['id' => explode(',', $privilege->portals)]);
        }
        $portals = $query->indexBy('id')->all();

        if ($place = PortalPlace::findOne(['user_id' => \Yii::$app->user->id])) {
            $places = explode(',',$place->portals);
            $portals = array_filter($portals,function($portal) use($places){
                return in_array($portal->id,$places);
            });
        }

        $statics = '';
        $info = '';
        foreach($portals as $portal){
            if($portal->is_static){
                $statics .= call_user_func([$portal->code,'widget']);
            } else {
                $info .= call_user_func([$portal->code,'widget']);
            }
        }

        return '<div class="row">'.$statics.'</div>' . '<div class="row">'.$info.'</div>';
    }
}

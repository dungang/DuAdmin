<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use DuAdmin\Models\DashboardWidget;
use DuAdmin\Models\Setting;

class DefaultController extends BackendController
{

    public function init()
    {
        parent::init();
        $this->guestActions = [
            'error'
        ];
        $this->userActions = [
            'index'
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'DuAdmin\Core\CoreErrorAction'
            ],
            'sorts' => [
                'class' => 'DuAdmin\Core\SortableAction'
            ]

        ];
    }

    public function actionIndex()
    {
        if ($index = Setting::getSettings('backend.index')) {
            return $this->redirect([
                '/' . ltrim($index)
            ]);
        }

        //counter widgets
        $counters = DashboardWidget::find()->select("id")->where("type = 'counter' and status = 1")->column();
        $charts = DashboardWidget::find()->select("id")->where("type = 'charts' and status = 1")->column();

        return $this->render('index', [
            'counters' => $counters,
            'charts' => $charts,
        ]);
    }
}

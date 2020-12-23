<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use yii\data\ArrayDataProvider;
use DuAdmin\Helpers\LoaderHelper;

class AddonController extends BackendController
{
    public function actionIndex(){
        
        $dataProvider = new ArrayDataProvider([
            'models' => LoaderHelper::dynamicParseAddons()
        ]);
        
        return $this->render('index',['dataProvider'=>$dataProvider]);
    }
}


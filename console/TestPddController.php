<?php
namespace app\console;

use app\addons\pdd\libs\PddClient;
use yii\console\Controller;

class TestPddController extends Controller {

    public function actionIndex(){
        $client = new  PddClient();
        $resp = $client->pddDdkGoodsSearch([
            'keyword'=>'手机'
        ]);

        print_r($resp);
    }
}
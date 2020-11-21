<?php
namespace app\console;

use app\addons\tbk\libs\TaobaokeClient;
use yii\console\Controller;

class TestTbkController extends Controller {

    public function actionIndex(){

        $client = new TaobaokeClient();

        // $data = $client->taobaoTbkDgOptimusMaterial([
        //     'material_id' => 27913,
        //     'adzone_id' => 104302750154
        // ]);

        $data = $client->taobaoTbkDgMaterialOptional([
                'material_id' => 27913,
                'adzone_id' => 104302750154,
                'q' => '杭州千岛湖滨江希尔顿度假房'
        ]);

        print_r($data);
    }
}
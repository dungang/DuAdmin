<?php
namespace app\backend\portals;

use yii\base\Widget;
use yii\httpclient\Client;
use yii\helpers\Json;

class GiteeProjectCommitsPortal extends Widget
{
    public function run(){
        
        $client  = new Client();
        $resp = $client->get("https://gitee.com/dungang/yii2-fast-kit/graph/master.json")->send();
        $html = 'No Data';
        if($resp->isOk) {
            $data = Json::decode($resp->content);
            $commits = $data['commits'];
            $html = "<table class='table table-bordered'>";
            $i = 0;
            foreach ($commits as $comment){
                $html .="<tr><td width='100'>" . date('Y-m-d',strtotime($comment['date'])) . "</td><td>" . $comment['message'] . "</td></tr>";
                if($i >= 9) {
                    break;
                }
                $i++;
            }
            $html .= "</table>";
        }

        return $this->render('gitee',['html'=>$html]);
    }
}


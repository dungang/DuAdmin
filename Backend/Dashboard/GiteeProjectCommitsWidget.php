<?php

namespace Backend\Dashboard;

use Yii;
use yii\base\Widget;
use yii\helpers\Json;
use yii\httpclient\Client;

class GiteeProjectCommitsWidget extends Widget
{

  public function run()
  {
    $data = Yii::$app->cache->getOrSet("gitee.commits", function () {
      $client = new Client();
      $resp = $client->get("https://gitee.com/dungang/DuAdmin/graph/master.json")->send();
      $data = null;
      if ($resp->isOk) {
        $data = Json::decode($resp->content);
      }
      return $data;
    }, 8600);
    $html = 'No Data';
    if ($data) {
      $commits = $data['commits'];
      $html = "<table class='table table-bordered'>";
      $i = 0;
      foreach ($commits as $comment) {
        $html .= "<tr><td width='100'>" . date('Y-m-d', strtotime($comment['date'])) . "</td><td>" . $comment['message'] . "</td></tr>";
        if ($i >= 9) {
          break;
        }
        $i++;
      }
      $html .= "</table>";
    }
    return $this->render('gitee', [
      'html' => $html
    ]);
  }
}

<?php

namespace Console;

use yii\console\Controller;
use yii\helpers\Json;
use yii\httpclient\Client;

class LingyinController extends Controller
{

    private $basePath = "http://hzflf.daolan.hzxiaosen.com/api/";

    private $client;

    public function init()
    {
        $this->client = new Client();
    }

    /**
     * 导入景点poi
     */
    public function actionAllPoi()
    {
        $response = $this->client->post($this->basePath . '/spotlist.jspx', [
            'id' => 5
        ], [
            'content-type' => 'application/json'
        ])
            ->setFormat(Client::FORMAT_JSON)
            ->send();
        if ($response->isOk) {
            $data = Json::decode($response->content);
            foreach ($data['pointList'] as $poi) {
                $images = [];
                if ($poi['imgList']) {
                    $images = array_map(function ($img) {
                        return '/profile' . $img['imgPath'];
                    }, $poi['imgList']);
                }
                $thumbnail = '';
                if ($poi['thumbImg']) {
                    $thumbnail = '/profile' . $poi['thumbImg'];
                }
                $poiData = [
                    'poi_id' => $poi['id'],
                    'area_id' => 1,
                    'type' => 'place',
                    'category' => $poi['type'],
                    'name' => $poi['name'],
                    'thumb_pic' => $thumbnail,
                    'main_pic' => $thumbnail,
                    'desc_pic' => Json::encode($images),
                    'audio' => $poi['audio'] ? '/profile' . $poi['audio'] : '',
                    'audio_desc' => '',
                    'desc' => $poi['introduce'] ? mb_substr($poi['introduce'], 0, 60, "utf-8") : '',
                    'lat' => $poi['latitude'],
                    'lng' => $poi['longitude'],
                    'intro' => $poi['introduce'],
                    'level' => $poi['showZoom'],
                    'min_zoom' => $poi['minZoom'],
                    'max_zoom' => $poi['maxZoom'],
                    'create_by' => 'admin',
                    'create_time' => date('Y-m-d H:i:s'),
                    'dept_id' => 101,
                    'user_id' => 1
                ];
                echo Json::encode($poiData) . "\n";
                \Yii::$app->db->createCommand()
                    ->insert('guide_poi', $poiData)
                    ->execute();
            }
        } else {
            echo $response->statusCode;
        }
    }

    /**
     * 导入推荐路线
     */
    public function actionAllLine()
    {
        $response = $this->client->post($this->basePath . '/spot_line.jspx', [
            'waresId' => 5
            // 'type' => 1
        ], [
            'content-type' => 'application/json'
        ])
            ->setFormat(Client::FORMAT_JSON)
            ->send();
        if ($response->isOk) {
            $data = Json::decode($response->content);
            foreach ($data['data'] as $line) {
                $points = [];
                if ($line['contactList']) {
                    $points = array_map(function ($p) {
                        return [
                            'lng' => $p['longitude'],
                            'lat' => $p['latitude']
                        ];
                    }, $line['contactList']);
                }
                $ids = [];
                if ($line['scenicList']) {
                    $ids = array_map(function ($id) {
                        return $id['id'];
                    }, $line['scenicList']);
                }
                $lineData = [
                    'route_name' => $line['name'],
                    'mileage' => floatval($line['distance']),
                    'calorie' => $line['calorie'],
                    'enter_poi_id' => $line['scenicList'][0]['id'],
                    'target_poi_id' => $line['scenicList'][count($line['scenicList']) - 1]['id'],
                    'recommended' => $line['type'],
                    'route_points' => Json::encode($points),
                    'poi_ids' => Json::encode($ids),
                    'create_by' => 'admin',
                    'create_time' => date('Y-m-d H:i:s'),
                    'dept_id' => 101,
                    'user_id' => 1
                ];
                echo Json::encode($lineData) . "\n";
                \Yii::$app->db->createCommand()
                    ->insert('guide_route', $lineData)
                    ->execute();
            }
        } else {
            echo $response->statusCode;
        }
    }

    /**
     * 导入设备导航路线
     */
    public function actionAllNavigator()
    {
        $response = $this->client->post($this->basePath . '/screen.jspx', [
            'screenId' => 1,
            'type' => 2
        ], [
            'content-type' => 'application/json'
        ])
            ->setFormat(Client::FORMAT_JSON)
            ->send();
        if ($response->isOk) {
            $data = Json::decode($response->content);
            foreach ($data['data']['middleList'] as $p) {
                $pathData = [
                    'device_id' => 1,
                    'poi_id' => $p['spotId'],
                    'spot_name' => $p['spotName'],
                    'spot_longitude' => $p['spotLongitude'],
                    'spot_latitude' => $p['spotLatitude'],
                    'spot_type' => 0,
                    'line_str' => $p['lineStr'],
                    'create_by' => 'admin',
                    'create_time' => date('Y-m-d H:i:s'),
                    'dept_id' => 101,
                    'user_id' => 1
                ];

                echo Json::encode($pathData) . "\n";
                \Yii::$app->db->createCommand()
                    ->insert('scr_spot', $pathData)
                    ->execute();
            }
        } else {
            echo $response->statusCode;
        }
    }
}

<?php
namespace Addons\ChinaRegion\Actions;

use Addons\ChinaRegion\Models\ChinaRegion;
use yii\base\Action;

class RegionsAction extends Action
{

    public function run($pid = 0, $level = 1, $current = null)
    {
        // 直辖市已赋值
        if ($pid === $current) {
            $regions = [
                ChinaRegion::findOne($pid)
            ];
        }

        $regions = ChinaRegion::findAll([
            'pid' => $pid,
            'level' => $level
        ]);

        // 直辖市初始化
        if (! $regions) {
            $regions = [
                ChinaRegion::findOne($pid)
            ];
        }
        if (count($regions) == 1) {
            $region = $regions[0]->toArray();
            $region['selected'] = true;
            $regions[0] = $region;
            return $regions;
        }
        return array_map(function ($region) use ($current) {
            $region = $region->toArray();
            if ($region['id'] == $current) {
                $region['selected'] = true;
            } else {
                $region['selected'] = false;
            }
            return $region;
        }, $regions);
    }
}
<?php
namespace Addons\ChinaRegion\Widgets;

use yii\base\Widget;
use Addons\ChinaRegion\Models\ChinaRegion;

/**
 * 显示省份城市和区县
 *
 * @author dungang<dungang@126.com>
 *        
 */
class RegionsShowWidget extends Widget
{

    /**
     * 显示的地区id数组
     *
     * @var array|null
     */
    public $regionIds = null;

    public function run()
    {
        if (is_array($this->regionIds)) {
            $names = array_map(function ($region) {
                return $region['name'];
            }, ChinaRegion::find()->select('name')
                ->where([
                    'id' => array_filter($this->regionIds)
            ])
                ->asArray()
                ->all());
            return implode(' ', $names);
        }
        return '';
    }
}

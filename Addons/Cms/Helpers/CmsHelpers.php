<?php

namespace Addons\Cms\Helpers;

use Addons\Cms\Models\Category;
use Addons\Cms\Models\PageBlock;
use DuAdmin\Models\Setting;
use QL\QueryList;
use yii\helpers\Json;

/**
 *
 * @author dungang
 */
class CmsHelpers
{
    const SETTING_PREFIX = 'addon-cms';

    public static function getSettingKey($name)
    {
        return self::SETTING_PREFIX . '.' . $name;
    }

    public static function getSetting($name)
    {
        return Setting::getSettings(self::getSettingKey($name));
    }

    public static function getSubCategories($pid)
    {
        return Category::find()->where(['pid' => $pid])->orderBy('sort')->asArray()->all();
    }

    public static function registerBlockAssets( $content )
    {
        $reg = '#data\-page\-block\-id=["\'](\d+?)["\']#im';
        if ( preg_match_all( $reg, $content, $matches ) ) {
            $blockIds = array_unique( $matches[ 1 ] );
            $blocks = PageBlock::findAll( ['id' => $blockIds] );
            foreach ( $blocks as $block ) {
                $assetClass = $block->namespace;
                if ( class_exists( $assetClass ) ) {
                    call_user_func( [$assetClass, 'registerBlockAssets'] );
                }
            }
        }
    }

    public static function parseDynamicPageBlock($content) {
        $ql =  QueryList::html($content);
        $elements = $ql->find("div[data-page-block-dynamic]");
        $elements->map(function($div){
            $widget = $div->attr('data-page-block-class');
            $config = [
                'params' => Json::decode($div->attr('data-params')),
                'htmlOptions' => Json::decode($div->attr('data-options'))
            ];
            $content = call_user_func([$widget,'code'],$config);
            $div->replaceWith($content);
        });
        return $ql->getHtml();
    }

}

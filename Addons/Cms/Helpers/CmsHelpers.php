<?php

namespace Addons\Cms\Helpers;

use Addons\Cms\Models\Category;
use DuAdmin\Models\Setting;

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

}

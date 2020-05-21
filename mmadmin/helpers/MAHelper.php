<?php

namespace app\mmadmin\helpers;

use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\mmadmin\components\MobileDetect;
use app\mmadmin\models\Setting;
use app\mmadmin\events\CustomerEvent;
use yii\base\Component;
use app\mmadmin\models\MailQueue;
use app\mmadmin\core\BackendController;
use Yii;
use yii\base\Arrayable;

/**
 * 系统工具类
 *
 * @author dungang
 */
class MAHelper
{

    protected static $agent_detect;

    /**
     * 是否是移动端
     * @return boolean
     */
    public static function IsMobile()
    {
        if (self::$agent_detect == null) {
            self::$agent_detect = new MobileDetect();
        }
        return self::$agent_detect->isMobile();
    }

    public static function isBackend()
    {
        return \Yii::$app->controller instanceof BackendController;
    }

    public static function isDevMode()
    {
        return (defined('YII_ENV') && YII_ENV == 'dev');
    }

    public static function swtichLanguage($language = null)
    {
        //更加参数识别语言
        //需要 \app\mmadmin\components\RewriteUrl的支持
        if ($language || $language = Yii::$app->request->get('_lang')) {
            Yii::$app->urlManager->common_params['_lang'] = $language;
            Yii::$app->language = $language;
        } else {
            // 根据浏览器识别语言
            if (($accept_langs = Yii::$app->request->acceptableLanguages) &&
                is_array($accept_langs) &&
                count($accept_langs) > 0
            ) {
                Yii::$app->language = Yii::$app->request->acceptableLanguages[0];
            }
        }
    }

    public static function getLanguagesTabsItem(array $route, $key = "language")
    {
        $langs = static::getSettingAssoc('site.i18n');
        $items = [];
        foreach ($langs as $lang => $text) {
            $items[] = [
                'name' => $text,
                'url' => array_merge($route, [$key => $lang])
            ];
        }
        return $items;
    }

    /**
     * 递归移除元素
     * @param array|Arrable $array
     * @param callable $callback
     * @return array
     */
    public static function walkRecursiveRemove($array, callable $callback)
    {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $array[$k] = static::walkRecursiveRemove($v, $callback);
            } else if ($v instanceof Arrayable) {
                $array[$k] = static::walkRecursiveRemove($v->toArray(), $callback);
            } else {
                if ($callback($v, $k)) {
                    unset($array[$k]);
                } else {
                    $array[$k] = strval($v);
                }
            }
        }

        return $array;
    }

    /**
     * 根据起始值，和长度，生产关系数组
     * @param number $start
     * @param number $size
     * @param string $textsuffix
     * @return string[]
     */
    public static function generateNumberMap($start = 1, $size = 12, $textsuffix = '')
    {
        $map = array();
        for ($i = $start; $i <= $size; $i++) {
            $map[$i] = $i . $textsuffix;
        }
        return $map;
    }

    /**
     * 将可识别的本地url转化为满足框架的数组格式，否则直接返回原始字符串
     *
     * @param string $url
     * @return array|string
     */
    public static function normalizeUrl2Route($url)
    {
        $url_parts = parse_url($url);
        if (empty($url_parts['host']) && isset($url_parts['query'])) {
            $params = [];
            parse_str($url_parts['query'], $params);
            if (empty($params['r'])) {
                $params['r'] = 'site/page';
            }
            $r = '/' . $params['r'];
            unset($params['r']);
            array_unshift($params, $r);
            return $params;
        } else {
            return $url;
        }
    }

    /**
     * 图片
     *
     * @param string $src
     * @param array $options
     * @return string
     */
    public static function img($src, $options)
    {
        return Html::img(ltrim($src, '/'), $options);
    }

    /**
     * 生成延迟加载图片，并默认设置base64的小图片
     *
     * @param string $src
     * @param string $thumb
     * @param array $options
     * @return string
     */
    public static function lazyLoadImage($src, $thumb = null, $options = [])
    {
        if ($thumb == null)
            $thumb = 'data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs=';
        $opts = ArrayHelper::merge([
            'data-original' => ltrim($src, '/'),
            'class' => 'lazyload'
        ], $options);
        return Html::img($thumb, $opts);
    }

    public static function powered()
    {
        return \Yii::t('yii', 'Powered by {soft}', [
            'soft' => \Yii::$app->name
        ]);
    }

    public static function getSetting($name)
    {
        return Setting::getSettings($name);
    }

    public static function getSettingAry($name)
    {
        return Setting::getSettingAry($name);
    }

    public static function getSettingAssoc($name)
    {
        return Setting::getSettingAssoc($name);
    }

    public static function unicodeDecode($unicode_str)
    {
        $json = '{"str":"' . $unicode_str . '"}';
        $arr = json_decode($json, true);
        if (empty($arr)) {
            return '';
        }
        return $arr['str'];
    }

    public static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * 将yii的query转换为一维数组
     *
     * @param string $root_key
     * @param array $array
     * @param array $one
     * @param boolean $is_root
     */
    public static function to1Array($root_key, $array, &$one, $is_root = true)
    {
        foreach ($array as $key => $val) {
            if ($is_root) {
                $key = $root_key . $key;
            } else {
                $key = $root_key . '[' . $key . ']';
            }
            if (\is_array($val)) {
                self::to1Array($key, $val, $one, false);
            } else {
                $one[$key] = $val;
            }
        }
    }

    /**
     * 验证是否是同一个链接
     *
     * @param array $items
     * @return array
     */
    public static function reActiveItem($items)
    {
        if (empty($items)) return $items;
        // 获取请求的路由，是完整的，头部不会自动添加'/'
        $route = \Yii::$app->requestedRoute;
        $params = [];
        self::to1Array('', \Yii::$app->request->get(), $params);
        $counters = [];
        foreach ($items as $i => $item) {
            if (is_array($item['url'])) {
                $checkRoute = \array_shift($item['url']);
                // 如果菜单的路由不是‘/’开头，则说明是当前控制器的action
                if (\strpos($checkRoute, '/') !== 0) {
                    $checkRoute = \Yii::$app->controller->uniqueId . '/' . $checkRoute;
                } else {
                    // 否则就是绝对的路由（头部包含了'/'）,抹掉头部的'/',方便和请求的路由比较
                    $checkRoute = \ltrim($checkRoute, '/');
                }
                // 对比路由地址，积一分
                if ($checkRoute == $route) {
                    $counters[$i] = 1;
                    if (is_array($item['url']) && \is_array($params)) {
                        $counters[$i] += count(array_intersect_assoc($item['url'], $params));
                    }
                }
            }
        }
        // 需要积分高的菜单选项
        $max = 0;
        $idx = 0;
        foreach ($counters as $i => $count) {
            if ($count > $max) {
                $max = $count;
                $idx = $i;
            }
        }
        // 找到后，添加激活属性
        $items[$idx]['isActive'] = true;
        return $items;
    }

    public static function betweenDayWithTimestamp($field, $date)
    {
        if ($date) {
            $start = strtotime($date);
            $end = 24 * 3600 + $start;
            return [
                'between',
                $field,
                $start,
                $end
            ];
        }
        return [];
    }

    /**
     * 把返回的数据集转换成Tree
     *
     * @param array $list
     *            要转换的数据集
     * @param string $pk
     *            主键
     * @param string $pid
     *            parent标记字段
     * @param string $child
     *            子节点字段
     * @param
     *            int
     * @return array
     * @author gang.dun <dungang@huluwa.cc>
     */
    public static function listToTree($list, $pk = 'id', $pid = 'pid', $child = 'items', $root = 0)
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = &$list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] = &$list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent = &$refer[$parentId];
                        $parent[$child][] = &$list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 计算列表元素的在树的节点深度
     *
     * @param array $items
     *            待计算的数组
     * @param number $parent_id
     *            父节点Id值
     * @param number $depth
     *            初始深度
     * @param string $idField
     *            健字段
     * @param string $parentField
     *            父节点字段
     * @return array
     */
    public static function calcListItemDepth($items, $parent_id = 0, $depth = 1, $idField = 'id', $parentField = 'pid')
    {
        $dep = array();
        foreach ($items as $item) {
            if ($item[$parentField] == $parent_id) {
                $item['dep'] = $depth;
                $dep[] = $item;
                $dep = array_merge($dep, self::calcListItemDepth($items, $item[$idField], $depth + 1, $idField, $parentField));
            }
        }
        return $dep;
    }

    /**
     * 特殊的处理方法，将列表转换程map，并计算dep
     * 在文本字段上添加对应深度的空格
     *
     * @param array $items
     * @param string $textField
     * @param string $idField
     * @param string $parentField
     * @return string[]
     */
    public static function list2MapLikeTreeWithDepth($items, $textField, $idField = 'id', $parentField = 'pid', $parent_id = 0, $depth = 1)
    {
        $depItems = static::calcListItemDepth($items, $parent_id, $depth, $idField, $parentField);

        $tree = [];
        $tab = self::unicodeDecode("\u3000"); // 特殊空格
        foreach ($depItems as $item) {

            $tree[$item[$idField]] = str_repeat($tab, ($item['dep'] - 1) * 2) . '└' . $item[$textField];
        }
        return $tree;
    }

    /**
     * 直接通过查询数据库模型生成对应的map树
     *
     * @param string $table
     * @param string $textField
     * @param null|array $filter
     * @param string $idField
     * @param string $parentField
     * @param number $parent_id
     * @param number $depth
     * @return string[]
     */
    public static function dbQueryAsMapLikeTree($table, $textField, $filter = null, $idField = 'id', $parentField = 'pid', $parent_id = 0, $depth = 1,$i18n_cate=null)
    {
        $items = (new Query())->select([
            $idField,
            $parentField,
            $textField
        ])
            ->from($table)
            ->where($filter)
            ->all();
        if($items && $i18n_cate !== null) {
            $items = array_map(function($item) use ($textField,$i18n_cate) {
                $item[$textField] = Yii::t($i18n_cate,$item[$textField]);
                return $item;
            },$items);
        }
        return self::list2MapLikeTreeWithDepth($items, $textField, $idField, $parentField, $parent_id, $depth);
    }

    /**
     * 以关联数组形式的返回参数值
     *
     * @param string $text
     * @return mixed[]
     */
    public static function parseText2Assoc($text)
    {
        $assoc = [];
        $lines = \explode("\n", trim($text));
        foreach ($lines as $line) {
            if (($line = trim($line, '\n\r\s'))) {
                $kv = explode(':', $line);
                $assoc[$kv[0]] = $kv[1];
            }
        }
        return $assoc;
    }

    /**
     * 生成带有group的下拉的数据集合
     *
     * @param array $items
     * @param string $textField
     * @param string $filter
     * @param string $idField
     * @param string $parentField
     * @return array[]|array
     */
    public static function groupOptions($items, $textField, $filter = null, $idField = 'id', $parentField = 'pid')
    {
        $options = [];
        foreach ($items as $id => $item) {
            if ($item[$parentField] == 0) {
                if (empty($options[$item[$textField]])) {
                    $options[$item[$textField]] = [];
                }
            } else {
                $group = $items[$item[$parentField]];

                $options[$group[$textField]][$id] = $item[$textField];
            }
        }

        return $options;
    }

    /**
     * 直接通过查询数据库模型生成带有group的下拉的数据集合
     *
     * @param string $table
     * @param string $textField
     * @param null|array $filter
     * @param string $idField
     * @param string $parentField
     * @param number $parent_id
     * @param number $depth
     * @return array
     */
    public static function dbQueryAsGroupOptions($table, $textField, $filter = null, $idField = 'id', $parentField = 'pid', $parent_id = 0, $depth = 1)
    {
        $items = (new Query())->select([
            $idField,
            $parentField,
            $textField
        ])
            ->from($table)
            ->where($filter)
            ->all();
        return self::groupOptions($items, $textField, $idField, $parentField);
    }

    /**
     * 批量执行replace into
     *
     * @param string $table
     * @param array $columns
     * @param array $rows
     * @return number
     */
    public static function batchReplaceInto($table, $columns, $rows)
    {
        $command = \Yii::$app->db->createCommand()->batchInsert($table, $columns, $rows);
        $command->setRawSql('REPLACE' . \substr($command->getRawSql(), 6));
        // echo $command->getRawSql();die;
        return $command->execute();
    }

    /**
     * 触发自定义事件
     *
     * @param string $name
     *            上下文的事件名称
     * @param mixed $payload
     *            传递的数据
     * @param Component $context
     *            默认为空，则表示是视图上下文
     */
    public static function triggerCustomCustomEvent($name, $payload = null, $context = null)
    {
        if ($context == null) {
            $context = \Yii::$app->view;
        }
        $context->trigger($name, new CustomerEvent([
            'payload' => $payload
        ]));
    }

    public static function sendMailerByQueue($from, $to, $subject, $body, $try_times = 1, $send_del = true, $time = null)
    {
        $mail = new MailQueue();
        $mail->sender = $from;
        $mail->recipient = $to;
        $mail->subject = $subject;
        $mail->content = $body;
        $mail->del_after_send = $send_del;
        $mail->time_to_send = $time;
        $mail->try_send = $try_times;
        return $mail->save(false);
    }

    public static function translation_link($category, $message)
    {
        return Html::a('<i class="fa fa-language"></i> ' . Yii::t('ma', 'Translation'), [
            '/translation/setting',
            'category' => $category, 'message' => $message
        ], [
            'class' => 'btn btn-sm btn-link',
            'data-toggle' => 'modal',
            'data-target' => '#modal-dailog',
        ]);
    }
}
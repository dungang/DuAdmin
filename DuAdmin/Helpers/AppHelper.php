<?php

namespace DuAdmin\Helpers;

use DuAdmin\Models\DictData;
use DuAdmin\Models\Setting;
use Exception;
use Yii;
use yii\base\Arrayable;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;

/**
 * 系统工具类
 *
 * @author dungang
 */
class AppHelper
{

    protected static $agent_detect;

    /**
     * 是否是移动端
     *
     * @return boolean
     */
    public static function IsMobile()
    {

        if (self::$agent_detect == null) {
            self::$agent_detect = Yii::createObject('DuAdmin\Components\MobileDetect');
        }
        return self::$agent_detect->isMobile();
    }

    /**
     * 判断是否是ajax请求，主要是区分表单的ajax验证
     *
     * @return boolean
     */
    public static function isAjaxNotPjax()
    {

        return Yii::$app->request->isAjax && Yii::$app->request->isPjax === false;
    }

    /**
     * 表单验证通过之后发起的表单请求
     * 是否ajax表单请求
     *
     * @return boolean
     */
    public static function isAjaxFormSubmitRequest()
    {

        return Yii::$app->request->isAjax && isset(Yii::$app->request->headers['ajax-submit']);
    }

    /**
     * ajax json 请求
     *
     * @return boolean
     */
    public static function isAjaxJson()
    {

        return Yii::$app->request->isAjax && false !== strpos(Yii::$app->request->headers['accept'], 'application/json');
    }

    /**
     * 是否ajax验证请求
     *
     * @return boolean
     */
    public static function isAjaxValidationRequest()
    {

        return Yii::$app->request->isAjax && (Yii::$app->request->post('ajax') || Yii::$app->request->post('ajax'));
    }

    /**
     * 显示一个默认大小的对话框的按钮
     *
     * @param string $text
     * @param string|array $url
     * @param array $options
     * @return string
     */
    public static function linkButtonWithSimpleModal($text, $url, $options = [])
    {

        $options = array_merge([
            'data-toggle' => 'modal',
            'data-target' => '#modal-dialog',
            'data-pjax'   => '0'
        ], $options);
        return Html::a($text, $url, $options);
    }

    /**
     * 显示一个小的对话框的按钮
     *
     * @param string $text
     * @param string|array $url
     * @param array $options
     * @return string
     */
    public static function linkButtonWithSmallSimpleModal($text, $url, $options = [])
    {

        $options = array_merge([
            'data-toggle'     => 'modal',
            'data-target'     => '#modal-dialog',
            'data-modal-size' => 'modal-sm',
            'data-pjax'       => '0'
        ], $options);
        return Html::a($text, $url, $options);
    }

    /**
     * 显示一个大的对话框的按钮
     *
     * @param string $text
     * @param string|array $url
     * @param array $options
     * @return string
     */
    public static function linkButtonWithBigSimpleModal($text, $url, $options = [])
    {

        $options = array_merge([
            'data-toggle'     => 'modal',
            'data-target'     => '#modal-dialog',
            'data-modal-size' => 'modal-lg',
            'data-pjax'       => '0'
        ], $options);
        return Html::a($text, $url, $options);
    }

    /**
     * 显示一个普通文本链接的按钮
     *
     * @param string $text
     * @param string|array $url
     * @param array $options
     * @return string
     */
    public static function linkButton($text, $url, $options = [])
    {
        $options = array_merge([
            'data-pjax'       => '0'
        ], $options);
        return Html::a($text, $url, $options);
    }

    /**
     * 显示一个删除按钮
     *
     * @param string $text
     * @param string|array $url
     * @param array $options
     * @return string
     */
    public static function linkDeleteButton($text, $url, $options = [])
    {

        $options = array_merge([
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method'  => 'post',
            'data-pjax'    => '0'
        ], $options);
        return Html::a($text, $url, $options);
    }

    public static function isDevMode()
    {

        return (defined('YII_ENV') && YII_ENV == 'dev');
    }

    public static function swtichLanguage($language = null)
    {

        // 更加参数识别语言
        // 需要 \DuAdmin\Components\RewriteUrl的支持
        if ($language || $language = Yii::$app->request->get('_lang')) {
            Yii::$app->urlManager->commonParams['_lang'] = $language;
            Yii::$app->language = $language;
        } else {
            // 根据浏览器识别语言
            if (($accept_langs = Yii::$app->request->acceptableLanguages) && is_array($accept_langs) && count($accept_langs) > 0) {
                Yii::$app->language = Yii::$app->request->acceptableLanguages[0];
            }
        }
        //解决非标准的语音浏览器zh-cn 应该是zh-CN
        $parts = explode('-', Yii::$app->language);
        if (count($parts) == 2) {
            Yii::$app->language = $parts[0] . "-" . strtoupper($parts[1]);
        }
    }

    /**
     * 获取语音列表
     * @param array $route
     * @param string $key
     * @return array
     */
    public static function getLanguagesTabsItem(array $route, $key = "language")
    {
        $languages = DictData::getDataLabels('system_languages');
        $items = [];
        foreach ($languages as $lang => $text) {
            $items[] = [
                'name' => $text,
                'url'  => array_merge($route, [
                    $key => $lang
                ])
            ];
        }
        return $items;
    }

    /**
     * 递归移除元素
     *
     * @param array|Arrayable $array
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
     *
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
            'class'         => 'lazyload'
        ], $options);
        return Html::img($thumb, $opts);
    }

    public static function powered()
    {

        return Html::a(\Yii::t('yii', 'Powered by {soft}', [
            'soft' => 'DUAdmin'
        ]), 'http://www.duadmin.com', [
            'target' => '_blank'
        ]);
    }

    public static function getSetting($name, $default = NULL)
    {

        return Setting::getSettings($name, $default);
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

    /**
     * 唯一编码
     * https://www.php.net/manual/zh/function.uniqid.php#120123
     *
     * @param integer $lenght
     * @return string
     */
    public static function uniqid($lenght = 13)
    {

        // uniqid gives 13 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }

    /**
     * 生成GUID
     *
     * @return string
     */
    public static function GUID()
    {

        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * 生成订单号1
     *
     * @return string
     */
    public static function createOrderNo1()
    {

        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * 生成订单号2
     *
     * @return string
     */
    public static function createOrderNo2()
    {

        return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    /**
     * 生成订单号方法3
     *
     * @return string
     */
    public static function createOderNo3()
    {

        $yCode = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J'
        ];
        return $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
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

        if (empty($items))
            return $items;
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
     *          要转换的数据集
     * @param string $pk
     *          主键
     * @param string $pid
     *          parent标记字段
     * @param string $child
     *          子节点字段
     * @param int|string $root
     * @return array
     * @author gang.dun <dungang@huluwa.cc>
     */
    public static function listToTree($list, $pk = 'id', $pid = 'pid', $child = 'children', $root = '0')
    {

        $list = array_map(function ($item) use ($root) {
            if (!isset($item['pid'])) {
                $item['pid'] = $root;
            }
            return $item;
        }, $list);
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
                // yii query asArray int all to string
                if ($root === $parentId) {
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
     *          待计算的数组
     * @param number $parent_id
     *          父节点Id值
     * @param number $depth
     *          初始深度
     * @param string $idField
     *          健字段
     * @param string $parentField
     *          父节点字段
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
    public static function dbQueryAsMapLikeTree($table, $textField, $filter = null, $idField = 'id', $parentField = 'pid', $parent_id = 0, $depth = 1, $i18n_cate = null)
    {

        $items = (new Query())->select([
            $idField,
            $parentField,
            $textField
        ])->from($table)->where($filter)->all();
        if ($items && $i18n_cate !== null) {
            $items = array_map(function ($item) use ($textField, $i18n_cate) {
                $item[$textField] = Yii::t($i18n_cate, $item[$textField]);
                return $item;
            }, $items);
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
        ])->from($table)->where($filter)->all();
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

    // public static function sendMailerByQueue($from, $to, $subject, $body, $try_times = 1, $send_del = true, $time = null)
    // {
    // $mail = new \DuAdmin\Models\MailQueue();
    // $mail->sender = $from;
    // $mail->recipient = $to;
    // $mail->subject = $subject;
    // $mail->content = $body;
    // $mail->del_after_send = $send_del;
    // $mail->time_to_send = $time;
    // $mail->try_send = $try_times;
    // return $mail->save(false);
    // }
    public static function translation_link($category, $message)
    {

        return Html::a('<i class="fa fa-language"></i> ' . Yii::t('da', 'Translation'), [
            '/translation/setting',
            'category' => $category,
            'message'  => $message
        ], [
            'class'       => 'btn btn-sm btn-link',
            'data-toggle' => 'modal',
            'data-target' => '#modal-dialog'
        ]);
    }

    public static function maxWidthImage($content, $width = "100%")
    {

        return str_replace("<img ", "<img style='max-width:" . $width . ";'", $content);
    }

    /**
     * 取汉字的第一个字的首字母
     *
     * @param string $str
     * @return string|null
     */
    public static function getFirstChar($str)
    {

        if (empty($str)) {
            return '';
        }
        $fir = $fchar = ord($str[0]);
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str[0]);
        }
        $s1 = @iconv('UTF-8', 'gb2312', $str);
        $s2 = @iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        if (!isset($s[0]) || !isset($s[1])) {
            return '';
        }
        $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;
        if (is_numeric($str)) {
            return $str;
        }
        if (($asc >= -20319 && $asc <= -20284) || $fir == 'A') {
            return 'A';
        }
        if (($asc >= -20283 && $asc <= -19776) || $fir == 'B') {
            return 'B';
        }
        if (($asc >= -19775 && $asc <= -19219) || $fir == 'C') {
            return 'C';
        }
        if (($asc >= -19218 && $asc <= -18711) || $fir == 'D') {
            return 'D';
        }
        if (($asc >= -18710 && $asc <= -18527) || $fir == 'E') {
            return 'E';
        }
        if (($asc >= -18526 && $asc <= -18240) || $fir == 'F') {
            return 'F';
        }
        if (($asc >= -18239 && $asc <= -17923) || $fir == 'G') {
            return 'G';
        }
        if (($asc >= -17922 && $asc <= -17418) || $fir == 'H') {
            return 'H';
        }
        if (($asc >= -17417 && $asc <= -16475) || $fir == 'J') {
            return 'J';
        }
        if (($asc >= -16474 && $asc <= -16213) || $fir == 'K') {
            return 'K';
        }
        if (($asc >= -16212 && $asc <= -15641) || $fir == 'L') {
            return 'L';
        }
        if (($asc >= -15640 && $asc <= -15166) || $fir == 'M') {
            return 'M';
        }
        if (($asc >= -15165 && $asc <= -14923) || $fir == 'N') {
            return 'N';
        }
        if (($asc >= -14922 && $asc <= -14915) || $fir == 'O') {
            return 'O';
        }
        if (($asc >= -14914 && $asc <= -14631) || $fir == 'P') {
            return 'P';
        }
        if (($asc >= -14630 && $asc <= -14150) || $fir == 'Q') {
            return 'Q';
        }
        if (($asc >= -14149 && $asc <= -14091) || $fir == 'R') {
            return 'R';
        }
        if (($asc >= -14090 && $asc <= -13319) || $fir == 'S') {
            return 'S';
        }
        if (($asc >= -13318 && $asc <= -12839) || $fir == 'T') {
            return 'T';
        }
        if (($asc >= -12838 && $asc <= -12557) || $fir == 'W') {
            return 'W';
        }
        if (($asc >= -12556 && $asc <= -11848) || $fir == 'X') {
            return 'X';
        }
        if (($asc >= -11847 && $asc <= -11056) || $fir == 'Y') {
            return 'Y';
        }
        if (($asc >= -11055 && $asc <= -10247) || $fir == 'Z') {
            return 'Z';
        }
        return '';
    }

    /**
     * 获取插件名称的所有列表
     *
     * @return array
     */
    public static function getAddonNames()
    {

        $dirs = FileHelper::findDirectories(\Yii::$app->basePath . '/Addons/', [
            'recursive' => false
        ]);
        return array_map(function ($dir) {
            return basename($dir);
        }, $dirs);
    }

    /**
     * 解析菜单url
     * route?param=val
     *
     * @param string $url
     * @params string $routePrefix
     */
    public static function parseDuAdminMenuUrl($url, $routePrefix = '')
    {

        if ($url) {
            $info = parse_url($url);
            $route = '';
            if (isset($info['path'])) {
                $route = $routePrefix . $info['path'];
            }
            $query = [];
            if (isset($info['query'])) {
                parse_str($info['query'], $query);
                if (empty($route) && isset($query['r'])) {
                    $route = $routePrefix . $query['r'];
                    unset($query['r']);
                }
            }
            if ($route) {
                array_unshift($query, $route);
                return $query;
            }
        }
        return null;
    }

    private static $frotendUrlManager = null;

    /**
     * 创建前端的url
     * @param $route
     * @return string
     */
    public static function createFrontendUrl($route)
    {
        if (empty(static::$frotendUrlManager)) {
            $frontendConfigFile = Yii::getAlias("@Frontend/Config/web.php");
            $config = require $frontendConfigFile;
            try {
                static::$frotendUrlManager = Yii::createObject($config['components']['urlManager']);
            } catch (Exception $e) {
                return null;
            }
        }
        return static::$frotendUrlManager->createUrl($route);
    }

    /**
     * 文件大小可读人性化
     */
    public static function fileSizeHumanFromKb($size)
    {
        $size  = doubleval($size);
        $rank = 0;
        $rankchar = 'KB';
        while ($size > 1024) {
            $size = $size / 1024;
            $rank++;
        }
        if ($rank == 1) {
            $rankchar = "MB";
        } else if ($rank == 2) {
            $rankchar = "GB";
        } else if ($rank == 3) {
            $rankchar = "TB";
        }
        $size = number_format($size, 2, '.', '');
        return  "" . $size . " " . $rankchar;
    }

    public static function seo($view, $keywords, $description, $options = [])
    {
        $view->registerMetaTag([
            'name'    => 'keywords',
            'content' => $keywords
        ], 'keywords');
        $view->registerMetaTag([
            'name'    => 'description',
            'content' => $description
        ], 'description');
        if ($options) {
            foreach ($options as $key => $val) {
                $view->registerMetaTag([
                    'name'    => $key,
                    'content' => $val
                ], $key);
            }
        }
    }
}

<?php
namespace app\kit\helpers;

use yii\base\NotSupportedException;
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\kit\models\User;
use app\kit\components\MobileDetect;
use app\kit\models\Setting;
use app\kit\events\CoreEvent;
use yii\base\Component;
use app\kit\models\MailQueue;

/**
 * 系统工具类
 *
 * @author dungang
 */
class KitHelper
{

    protected static $agent_detect;

    public static function IsMobile()
    {
        if (self::$agent_detect == null) {
            self::$agent_detect = new MobileDetect();
        }
        return self::$agent_detect->isMobile();
    }

    public static function img($src, $options)
    {
        return Html::img(ltrim($src, '/'), $options);
    }

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
            'soft' => '<a href="https://baiyuan.weifutek.com/" rel="external">' . \Yii::$app->name . '</a>'
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
        if (empty($arr))
            return '';
        return $arr['str'];
    }

    public static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function isAdmin()
    {
        return \Yii::$app->user->identity->is_admin;
    }

    /**
     * 将yii的query转换为一维数组
     *
     * @param string $root_key
     * @param array $array
     * @param array $one
     * @param boolean $is_root
     */
    public function to1Array($root_key, $array, &$one, $is_root = true)
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
        //获取请求的路由，是完整的，头部不会自动添加'/'
        $route = \Yii::$app->requestedRoute;
        $params = [];
        self::to1Array('', \Yii::$app->request->get(), $params);
        $counters = [];
        foreach ($items as $i => $item) {
            if (is_array($item['url'])) {
                $checkRoute = \array_shift($item['url']);
                //如果菜单的路由不是‘/’开头，则说明是当前控制器的action
                if (\strpos($checkRoute, '/') !== 0) {
                    $checkRoute = \Yii::$app->controller->uniqueId . '/' . $checkRoute;
                } else {
                    //否则就是绝对的路由（头部包含了'/'）,抹掉头部的'/',方便和请求的路由比较
                    $checkRoute = \ltrim($checkRoute, '/');
                }
                //对比路由地址，积一分
                if ($checkRoute == $route) {
                    $counters[$i] = 1;
                    if (is_array($item['url']) && \is_array($params)) {
                        $counters[$i] += count(array_intersect_assoc($item['url'], $params));
                    }
                }
            }
        }
        //需要积分高的菜单选项
        $max = 0;
        $idx = 0;
        foreach ($counters as $i => $count) {
            if ($count > $max) {
                $max = $count;
                $idx = $i;
            }
        }
        //找到后，添加激活属性
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

    public static function memberNames($ids)
    {
        $query = new Query();
        $membs = $query->select('id,name')
            ->from(User::tableName())
            ->where([
            'id' => $ids
        ])
            ->all();
        return ArrayHelper::map($membs, 'id', 'name');
    }

    /**
     *
     * @param string $text
     * @param array $url
     * @param array $options
     * @return string
     */
    public static function orgLinkButton($text, $url, $options)
    {
        if (is_array($url)) {
            return self::hasProjectPermission($url[0]) ? Html::a($text, $url, $options) : '';
        }
        throw new NotSupportedException('argment url be must an array!');
    }

    /**
     *
     * @param array $action
     * @param string $content
     * @param array $options
     * @throws NotSupportedException
     * @return string
     */
    public static function orgSubmitButton($action, $content = '', $options = [])
    {
        if (is_array($action)) {
            return self::hasProjectPermission($action[0]) ? Html::SubmitButton($content, $options) : '';
        }
        throw new NotSupportedException('argment url be must an array!');
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
                $refer[$data[$pk]] = & $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] = & $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent = & $refer[$parentId];
                        $parent[$child][] = & $list[$key];
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
        $tab = self::unicodeDecode("\u3000"); //特殊空格
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
    public static function dbQueryAsMapLikeTree($table, $textField, $filter = null, $idField = 'id', $parentField = 'pid', $parent_id = 0, $depth = 1)
    {
        $items = (new Query())->select([
            $idField,
            $parentField,
            $textField
        ])
            ->from($table)
            ->where($filter)
            ->all();
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
            if ($line = trim($line, '\n\r\s')) {
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
        //echo $command->getRawSql();die;
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
    public static function triggerCustomCoreEvent($name, $payload = null, $context = null)
    {
        if ($context == null) {
            $context = \Yii::$app->view;
        }
        $context->trigger($name, new CoreEvent([
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
}


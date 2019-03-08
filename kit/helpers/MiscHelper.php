<?php
namespace app\kit\helpers;

use yii\base\NotSupportedException;
use yii\helpers\Html;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\kit\models\User;

/**
 * 系统工具类
 *
 * @author dungang
 *        
 */
class MiscHelper
{

    public static function powered()
    {
        return \Yii::t('yii', 'Powered by {baiyuan}', [
            'baiyuan' => '<a href="https://baiyuan.weifutek.com/" rel="external">' . \Yii::$app->name . '</a>'
        ]);
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

    public static function goBackButton()
    {
        return Html::button('<i class="glyphicon glyphicon-chevron-left"></i> 返回', [
            'class' => 'btn btn-warning',
            'onclick' => 'window.history.back()'
        ]);
    }
    
    public function to1Array($root_key,$array,&$one,$is_root=true){
        foreach($array as $key => $val) {
            if($is_root) {
                $key = $root_key . $key;
            } else {
                $key = $root_key . '[' . $key.']';
            }
            if(\is_array($val)) {
                self::to1Array($key, $val, $one, false);
            } else {
                $one[$key] = $val;
            }
        }
    }
    
    /**
     * 验证是否是同一个链接
     * @param array $items 
     * @return array
     */
    public static function reActiveItem($items){
        $route = \Yii::$app->requestedRoute;
        $params = [];
        self::to1Array('', \Yii::$app->request->get(), $params);
        $counters=[];
        foreach($items as $i => $item) {
            if(is_array($item['url'])) {
                $checkRoute = \array_shift($item['url']);
                if($checkRoute == '/' .$route) {
                    $counters[$i]=1;
                    if(is_array( $item['url']) && \is_array($params)){
                        $counters[$i] += count(array_intersect_assoc( $item['url'],$params));
                    }
                }
                
            }
        }
        $max = 0; $idx = 0;
        foreach($counters as $i => $count) {
            if($count>$max) {
                $max = $count;
                $idx = $i;
            }
        }
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
}


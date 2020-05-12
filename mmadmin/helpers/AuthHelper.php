<?php

namespace app\mmadmin\helpers;

use Yii;
use app\mmadmin\models\User;
use yii\helpers\Html;

/**
 * 权限认证相关的帮助类
 */
class AuthHelper
{

    /**
     * 判断当前用户是否是管理用户
     * @return boolean
     */
    public static function isAdmin()
    {
        return Yii::$app->user->identity->is_admin;
    }

    /**
     * 检查路由权限
     *
     * @param string $route
     * @param array $params 额外参数（如果改路由由规则rule，参数会传递给规则验证）
     * @return boolean
     */
    public static function can($route, $params = [])
    {
        /* @var \app\mmadmin\models\User $user */
        $user = Yii::$app->user->getIdentity();
        // step2. If user has been deleted, then destroy session and redirect to home page
        if ($user === null) {
            Yii::$app->getSession()->destroy();
            return false;
            //如果是后台控制器，必须是管理者属性的用户
        } else if ($user->is_admin != 1) {
            return false;
            // step3. 如果是超级管理员
        } else if ($user->is_super) {
            return true;
            // step4. 如果是非激活用户
        } else if ($user->status != User::STATUS_ACTIVE) {
            return false;
        } else {
            // step6. 路由权限检查
            // 后台管理权限检查
            return Yii::$app->user->can('/' . ltrim($route, "/"), $params);
        }
    }

    /**
     * 支持权限验证的锚点
     *
     * @param string $text
     * @param string|array|null $url
     * @param array $options
     * @return string
     */
    public static function a($text, $url = null, $options = [])
    {
        $tmp_url = KitHelper::normalizeUrl2Route($url);
        if(is_array($tmp_url)) {
            $route = $tmp_url[0];
            unset($tmp_url[0]);
            if(self::can($route,$tmp_url)){
                return Html::a($text, $url, $options);
            } else {
                return '';
            }
        }
        return Html::a($text, $url, $options);
    }
}

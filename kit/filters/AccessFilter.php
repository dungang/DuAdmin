<?php
namespace app\kit\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use app\kit\models\User;
use app\kit\models\AcRoute;

/**
 * 替代默认的ACF
 *
 * @author dungang
 *        
 */
class AccessFilter extends ActionFilter
{

    const ID = 'access-filter';

    /**
     *
     * @var callable a callback that will be called if the access should be denied
     *      to the current user. If not set, [[denyAccess()]] will be called.
     *     
     *      The signature of the callback should be as follows:
     *     
     *      ~~~
     *      function ($rule, $action)
     *      ~~~
     *     
     *      where `$rule` is the rule that denies the user, and `$action` is the current [[Action|action]] object.
     *      `$rule` can be `null` if access is denied because none of the rules matched.
     */
    public $denyCallback;

    /**
     * action执行之前
     *
     * @param \yii\base\Action $action
     *            将要执行的action
     * @return boolean 执行的action是否继续执行
     */
    public function beforeAction($action)
    {
        /* @var \app\kit\core\BackendController $controller  */
        $controller = $this->owner;

        // route
        $route = '/' . $action->getUniqueId();

        // step1. 是游客,首先检查是否游客级别的action
        if (in_array($action->id, $controller->guestActions)) {
            return true;
        }
        //如果检查通过，还继续，则不允许非游客访问
        if (\Yii::$app->user->isGuest) {
            $this->denyAccess();
        } else {
            /* @var User $user */
            $user = Yii::$app->user->getIdentity();

            // step2. If user has been deleted, then destroy session and redirect to home page
            if ($user === null) {
                Yii::$app->getSession()->destroy();
                $this->denyAccess();

            //如果是后台控制器，必须是管理者属性的用户
            } else if ($user->is_admin != 1) {
                return false;
                // step3. 如果是超级管理员
            } else if ($user->is_super) {
                return true;

                // step4. 如果是非激活用户
            } else if ($user->status != User::STATUS_ACTIVE) {
                Yii::$app->user->logout();
                Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());

                // step5. 登录用户可以访问的actions
            } else if (in_array($action->id, $controller->userActions)) {
                return true;
            } else {
                // step6. 路由权限检查
                $params = Yii::$app->request->isPost ? Yii::$app->request->getBodyParams() : Yii::$app->request->getQueryParams();

                // 后台管理权限检查
                \Yii::$app->user->can($route, $params);
            }
        }

        if (isset($this->denyCallback)) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            $this->denyAccess();
        }
        return false;
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     *
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess()
    {
        if (Yii::$app->user->getIsGuest()) {
            Yii::$app->user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
}


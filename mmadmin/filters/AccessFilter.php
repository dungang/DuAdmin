<?php
namespace app\mmadmin\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use app\mmadmin\models\User;
use app\mmadmin\models\ActionLog;
use yii\helpers\Json;
use app\mmadmin\core\LongPollAction;
use app\mmadmin\core\LoopAction;
use yii\web\ErrorAction;

/**
 * 替代默认的ACF
 * 负责backend权限校验和操作日志的记录
 *
 * @author dungang
 *        
 */
class AccessFilter extends ActionFilter
{

    const ID = 'access-filter';

    /**
     * action执行之前
     *
     * @param \yii\base\Action $action
     *            将要执行的action
     * @return boolean 执行的action是否继续执行
     */
    public function beforeAction($action)
    {
        /* @var \app\mmadmin\core\BackendController $controller  */
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
            //如果是后台控制器，
            if ($user === null) {
                Yii::$app->getSession()->destroy();
                $this->denyAccess();
            }

            // step3. 如果是超级管理员
            if ($user->is_super) {
                return true;
            }
            //必须是管理者属性的用户
            if ($user->is_admin == 1) {
                // step4. 如果是非激活用户
                if ($user->status != User::STATUS_ACTIVE) {
                    Yii::$app->user->logout();
                    Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());

                    // step5. 登录用户可以访问的actions
                } else if (in_array($action->id, $controller->userActions)) {
                    return true;
                } else {
                    // step6. 路由权限检查
                    $params = Yii::$app->request->isPost ? Yii::$app->request->getBodyParams() : Yii::$app->request->getQueryParams();
                    // 后台管理权限检查
                    if (\Yii::$app->user->can($route, $params)) {
                        return true;
                    }
                }
            }
        }

        $this->denyAccess();
        return false;
    }

    public function afterAction($action, $result)
    {
        if ($action instanceof ErrorAction) {
            return $result;
        } else if ($action instanceof LongPollAction) {
            return $result;
        } else if ($action instanceof LoopAction) {
            return $result;
        } else {
            if (!\Yii::$app->user->isGuest) {
                $data = $_REQUEST;
                unset($data['r'],$data['_csrf']);
                $log = new ActionLog([
                    'user_id' => \Yii::$app->user->id,
                    'action' => $action->getUniqueId(),
                    'ip' => ip2long(\Yii::$app->request->getRemoteIP()),
                    'method'=> strtoupper(\Yii::$app->request->method),
                    'data' => Json::encode($data)
                ]);
                $log->save(false);
            }
            return $result;
        }
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

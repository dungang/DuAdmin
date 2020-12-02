<?php
namespace DuAdmin\Filters;

use yii\base\Behavior;
use yii\base\Event;
use DuAdmin\Forms\PostRateLimitForm;
use yii\web\Controller;
use yii\web\Response;
use yii\web\View;

/**
 * 暂时使用session记录数据
 *
 * @author dungang
 */
class PostRateLimitFilter extends Behavior
{

    /**
     * 已经过滤了
     *
     * @var boolean
     */
    private static $is_filtered = false;

    public $exclude_routes = [
        'site/captcha'
    ];

    /**
     * 限制次数默认是10次
     *
     * @var string
     */
    public $max_times = 10;

    /**
     * 默认是900毫秒
     *
     * @var string
     */
    public $max_interval_ms = 900;

    private $ddos_time_key = '__ddos_time';

    private $ddos_max_times_key = '__ddos_max_times';

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    /**
     *
     * @param Event $event
     */
    public function beforeAction($event)
    {
        if (self::$is_filtered === false) {
            self::$is_filtered = true;
            if (\Yii::$app->request->isPost) {
                $current_time = microtime(true);
                if (! in_array(\Yii::$app->controller->route, $this->exclude_routes)) {
                    //超过不正常请求的次数上限
                    if ($this->getBadRequestTimes() >= $this->max_times) {
                        $event->handled = true;
                        $this->validateCaptach($event->sender);
                        return false;
                    }
                    $last_time = $this->getLastRequestTime();
                    $calc_time = $last_time + ($this->max_interval_ms / 1000);
                    //如果间隔时间小于最大间隔时间，则表示不正常的请求
                    if ($calc_time >= $current_time) {
                        $this->setBadRequestTimes();
                    }
                }

                $this->setLastRequestTime($current_time);
            } else {
                if ($this->getBadRequestTimes() >= $this->max_times) {
                    \Yii::$app->view->on(View::EVENT_END_BODY, function ($event) {
                        echo $this->renderForm(\Yii::$app->controller);
                    });
                }
            }
        }
    }

    /**
     *
     * @param Controller $controller
     * @param PostRateLimitForm $model
     */
    protected function renderForm($controller, $model = null)
    {
        $model = $model ?: new PostRateLimitForm();
        return $controller->renderFile('@DuAdmin/views/post-rate-limit-form.php', [
            'model' => $model
        ]);
    }

    protected function sendContent($content)
    {
        if (! ($content instanceof Response)) {
            \Yii::$app->response->content = $content;
        }
        \YIi::$app->end();
    }

    protected function clear()
    {
        unset($_SESSION[$this->ddos_time_key], $_SESSION[$this->ddos_max_times_key]);
    }

    /**
     *
     * @param Controller $controller
     * @return boolean
     */
    protected function validateCaptach($controller)
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->controller->redirect(\Yii::$app->request->referrer);
        }

        $model = new PostRateLimitForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $this->clear();
            $referer = \Yii::$app->request->referrer;
            $this->sendContent($controller->redirect($referer));
            return true;
        }
        $this->renderForm($controller, $model);

        $this->sendContent($this->renderForm($controller, $model));
        return false;
    }

    protected function setBadRequestTimes()
    {
        \Yii::$app->session->set($this->ddos_max_times_key, $this->getBadRequestTimes() + 1);
    }

    protected function getBadRequestTimes()
    {
        return \Yii::$app->session->get($this->ddos_max_times_key, 0);
    }

    protected function getLastRequestTime()
    {
        return \Yii::$app->session->get($this->ddos_time_key, 0);
    }

    protected function setLastRequestTime($time)
    {
        \Yii::$app->session->set($this->ddos_time_key, $time);
    }
}


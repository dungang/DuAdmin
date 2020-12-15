<?php
namespace DuAdmin\Core;

use DuAdmin\Hooks\BaseCtrInitedHook;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\base\ActionEvent;
use yii\helpers\Url;
use yii\base\Event;
use DuAdmin\Helpers\AppHelper;

class BaseController extends Controller
{

    const EVENT_BEFORE_RENDER = 'beforeRender';

    /**
     * 请求的方法过滤
     *
     * @var array
     */
    public $verbsActions = [];

    public function init()
    {
        parent::init();
        BaseCtrInitedHook::emit($this);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $defaultBehaviors = [];
        $defaultBehaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => $this->verbsActions
        ];
        if (($bs = $this->loadBehaviors())) {
            foreach ($bs as $b => $h) {
                $defaultBehaviors[$b] = $h;
            }
        }
        return $defaultBehaviors;
    }

    /**
     * 动态加载其他得行为
     *
     * @return null|array
     */
    protected function loadBehaviors()
    {
        return null;
    }

    /**
     * 加载配置
     *
     * @param string $path
     * @return boolean|array
     */
    protected function loadConfig($path)
    {
        $file = \Yii::getAlias("@app/config/" . $path);
        if (file_exists($file)) {
            return require $file;
        }
        return false;
    }

    public function beforeRender($params)
    {
        $event = new Event();
        $event->data = $params;
        $this->trigger(self::EVENT_BEFORE_RENDER, $event);
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Controller::afterAction()
     */
    public function afterAction($action, $result)
    {
        $event = new ActionEvent($action);
        $event->result = $result;
        $this->trigger(self::EVENT_AFTER_ACTION, $event);
        // 处理action返回的结果
        // DuAdmin/Core/BaseController封装了很多控制器渲染的方法，
        // 很多都是返回的数组结构的结果
        if (is_array($result)) {
            if (AppHelper::isAjaxFormSubmitRequest() || AppHelper::isAjaxJson()) {
                $event->result = $this->asJson($result);
            } else {
                // 如果是数组
                if (isset($result['view']) && ! empty($result['view'])) {
                    $this->renderResult($event, $result);
                } else if (isset($result['redirectUrl']) && ! empty($result['redirectUrl'])) {
                    // 如果是跳转
                    $event->result = \Yii::$app->getResponse()->redirect(Url::to($result['redirectUrl']), $result['statusCode']);
                } else {
                    // 默认的控制器的处理逻辑
                    unset($result['view'], $result['redirectUrl']);
                    $event->result = $this->asJson($result);
                }
            }
        }
        return $event->result;
    }

    private function renderResult($event, $result)
    {
        if (\Yii::$app->request->isAjax) {
            $event->result = $this->renderAjax($result['view'], $result['data']);
        } else {
            $event->result = $this->render($result['view'], $result['data']);
        }
    }

    private final function setFlash($status, $message)
    {
        if (! \Yii::$app->request->isAjax) {
            if ($status == 'success') {
                \Yii::$app->session->setFlash("success", $message);
            } else {
                \Yii::$app->session->setFlash("error", $message);
            }
        }
    }

    /**
     * 跳转
     *
     * @param string $status
     * @param string $url
     * @param number $statusCode
     * @param string $message
     * @return mixed|number[]|string[]
     */
    private final function thenRedirect($status, $url, $statusCode = 302, $message = '')
    {
        $this->setFlash($status, $message);
        return [
            'status' => $status,
            'redirectUrl' => $url,
            'statusCode' => $statusCode,
            'message' => $message
        ];
    }

    public final function redirectOnSuccess($url, $message = '处理成功')
    {
        return $this->thenRedirect('success', $url, 302, $message);
    }

    public final function redirectOnFail($url, $message = '处理失败')
    {
        return $this->thenRedirect('fail', $url, 302, $message);
    }

    public final function redirectOnException($url, $message = '处理异常')
    {
        return $this->thenRedirect('exception', $url, 302, $message);
    }

    public final function goHomeOnSuccess()
    {
        return $this->redirectOnSuccess(\Yii::$app->getHomeUrl(), '登录成功');
    }

    public final function goHomeOnFail()
    {
        return $this->redirectOnFail(\Yii::$app->getHomeUrl());
    }

    public final function gohomeOnException()
    {
        return $this->redirectOnException(\Yii::$app->getHomeUrl());
    }

    public final function goBackOnSuccess($defaultUrl = null)
    {
        return $this->redirectOnSuccess(\Yii::$app->getUser()
            ->getReturnUrl($defaultUrl),'登录成功');
    }

    public final function goBackOnFail($defaultUrl = null)
    {
        return $this->redirectOnFail(\Yii::$app->getUser()
            ->getReturnUrl($defaultUrl));
    }

    public final function goBackOnExcption($defaultUrl = null)
    {
        return $this->redirectOnException(\Yii::$app->getUser()
            ->getReturnUrl($defaultUrl));
    }

    public final function refreshOnSuccess($anchor = '')
    {
        return $this->redirectOnSuccess(\Yii::$app->getRequest()
            ->getUrl() . $anchor);
    }

    public final function refreshOnFail($anchor = '')
    {
        return $this->redirectOnFail(\Yii::$app->getRequest()
            ->getUrl() . $anchor);
    }

    public final function refreshOnExcepion($anchor = '')
    {
        return $this->redirectOnException(\Yii::$app->getRequest()
            ->getUrl() . $anchor);
    }

    /**
     * 返回
     *
     * @param string $status
     * @param string $view
     * @param array|object $params
     * @param string $message
     * @return array
     */
    private final function thenRender($status = 'success', $view = 'index', $params = [], $message = '')
    {
        $this->setFlash($status, $message);
        return [
            'status' => $status,
            'view' => $view,
            'message' => $message,
            'data' => $params
        ];
    }

    /**
     * 当成功的时候返回
     *
     * @param string $view
     * @param array $params
     * @param string $message
     * @return array
     */
    public final function renderOnSuccess($view, $params = [], $message = '处理成功')
    {
        return $this->thenRender('success', $view, $params, $message);
    }

    /**
     * 当成功的时候返回
     *
     * @param array $params
     * @param string $message
     * @return array
     */
    public final function renderWithoutViewOnSuccess($params = [], $message = '处理成功')
    {
        return $this->thenRender('success', null, $params, $message);
    }

    /**
     * 当失败的时候返回
     *
     * @param array $params
     * @param string $message
     * @return array
     */
    public final function renderOnFail($view, $params = [], $message = '处理失败')
    {
        return $this->thenRender('error', $view, $params, $message);
    }

    /**
     * 当失败的时候返回
     *
     * @param array $params
     * @param string $message
     * @return array
     */
    public final function renderWithoutViewOnFail($params = [], $message = '处理失败')
    {
        return $this->thenRender('error', null, $params, $message);
    }

    /**
     * 当异常的时候返回
     *
     * @param string $view
     * @param array $params
     * @param string $message
     * @return array
     */
    public final function renderOnException($view, $params = [], $message = '处理异常')
    {
        return $this->thenRender('exception', $view, $params, $message);
    }

    /**
     * 当异常的时候返回
     *
     * @param array $params
     * @param string $message
     * @return array
     */
    public final function renderwithoutViewOnException($params = [], $message = '处理异常')
    {
        return $this->thenRender('exception', null, $params, $message);
    }

    public function renderView($view, $params = [])
    {
        return [
            'status' => 'success',
            'view' => $view,
            'data' => $params
        ];
    }

    public function renderList($view, $params = [])
    {
        return $this->renderView($view, $params);
    }

    public function render($view, $params = [])
    {
        if (\Yii::$app->request->isAjax) {
            $result = parent::renderAjax($view, $params);
            return $result;
        }
        return parent::render($view, $params);
    }
}

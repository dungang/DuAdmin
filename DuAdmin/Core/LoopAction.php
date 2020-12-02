<?php
namespace DuAdmin\Core;

use yii\base\Action;

/**
 * 循环执行action
 * 注意：单词运行调试时
 *
 * @author dungang
 */
class LoopAction extends Action
{

    public $debug = false;

    /**
     * php线程睡眠间隔时间
     *
     * @var integer
     */
    public $sleepTimeSeconds = 1;

    /**
     * 句柄实现类
     *
     * @var string
     */
    public $longPollingHandlerClass = null;

    /**
     * 在运行业务句柄之前，可以处理的业务。
     * 返回值为boolean，true表示可以继续，false直接返回，忽略处理loop句柄
     * 目的可以达到不重复执行loop句柄
     *
     * @var callable
     */
    public $beforeRunCallback = null;

    /**
     * 业务处理句柄，不同业务使用不同的句柄实现类
     *
     * @var ILongPollHandler
     */
    protected $handler;

    protected function beforeRun()
    {
        if ($this->beforeRunCallback) {
            return call_user_func($this->beforeRunCallback);
        }
        return true;
    }

    public function init()
    {
        $this->handler = \Yii::createObject([
            'class' => $this->longPollingHandlerClass,
            'debug' => $this->debug
        ]);
    }

    public function run()
    {
        return \Yii::createObject([
            'class' => LoopResponse::className(),
            'sleepTime' => $this->sleepTimeSeconds,
            'handler' => $this->handler
        ]);
    }
}


<?php
namespace DuAdmin\Core;

use yii\web\Response;

class LoopResponse extends Response
{

    /**
     * 业务处理句柄，不同业务使用不同的句柄实现类
     *
     * @var ILongPollHandler
     */
    public $handler;

    public $sleepTime = 1;

    protected function prepare()
    {
        \Yii::$app->getSession()->close();
    }

    /**
     * Sends the response content to the client.
     */
    protected function sendContent()
    {
        set_time_limit(0);
        ignore_user_abort(true);
        while (true) {
            //\Yii::$app->db->close();
            sleep($this->sleepTime);
            //usleep($micro_seconds)
            //\Yii::$app->db->open();
            $this->checkDbConnection();
            flush(); //flush to notify php still alive
            if ($this->handler->process()) {
                flush();
                break;
            }
        }
    }

    /**
     * 检查数据库是否正常，如果已经关闭则重新打开
     */
    protected function checkDbConnection()
    {
        if (! \Yii::$app->db->isActive) {
            \Yii::$app->db->open();
        }
    }
}


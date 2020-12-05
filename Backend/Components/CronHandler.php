<?php
namespace Backend\Components;

use Yii;
use DuAdmin\Core\ILongPollHandler;
use Backend\Models\Cron;
use yii\httpclient\Client;
use DuAdmin\Components\Crontab;
use DuAdmin\Helpers\CrontabHelper;

/**
 * 检查cron 表中的定时任务的状态
 * 如果激活，则根据定时执行定时任务
 * 为了达到任务处理时间符合设定的时间，
 * 则通过发起异步的http请求实现
 *
 * @author dungang
 */
class CronHandler extends ILongPollHandler
{

    private $_httpClient;

    public function init()
    {
        // 初始化一个异步请求的HttpClient
        $this->_httpClient = new Client([
            'transport' => '\DuAdmin\Components\AsyncStreamTransport'
        ]);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \DuAdmin\Core\ILongPollHandler::process()
     */
    public function process()
    {
        // 如果没有启动cron服务，则退出循环
        if (! CrontabHelper::getCronStatus()) {
            return true;
        }

        if ($tasks = Cron::findAll([
            'isActive' => true,
            'isOk' => true
        ])) {
            foreach ($tasks as $task) {

                $time = null;
                try {
                    $time = Crontab::parse($task->mhdmd);
                } catch (\InvalidArgumentException $e) {
                    Yii::warning('任务的cron表达式格式不正确,' . $e->getMessage(), __METHOD__);
                    Yii::warning($e->getTraceAsString(), __METHOD__);
                    // 更新任务为is_ok=0;
                    $this->debug || $task->goBad($e->getMessage());
                    continue;
                }
                $cur = time();
                if (\intval($time) <= $cur) {
                    // 更新任务的执行时间
                    $task->run_at = $cur;
                    $task->save(false);
                    $url = Yii::$app->urlManager->createAbsoluteUrl([
                        '/task',
                        'id' => $task->id,
                        'token' => $task->token
                    ]);
                    Yii::info('Starting One Task : ' . $task->task . ': ' . $url, __METHOD__);
                    // echo $url;die;
                    // 发送异步请求
                    $this->_httpClient->get($url)->send();
                }
            }
        }
        // 永远执行，不关闭
        // false 表示不退出循环，
        // true 表示退出循环
        return $this->whenDebugNotLoop();
    }
}


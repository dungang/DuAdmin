<?php
namespace app\backend\task\controllers;

use app\kit\core\TaskController;
use app\kit\models\MailQueue;
use app\kit\helpers\KitHelper;

/**
 *
 * @author dungang
 */
class SendMailController extends TaskController
{

    /**
     * (non-PHPdoc)
     *
     * @see \app\kit\core\TaskController::execJob()
     */
    protected function execJob($param, $task)
    {
        if ($mails = MailQueue::find()->where([
            'status' => 'TODO'
        ])
            ->limit(10)
            ->orderBy('id desc')
            ->all());
        {
            if ($this->enableSendEmailer()) {
                \array_walk($mails, function ($mail) {
                    $this->process($mail);
                });
            }
        }
    }

    /**
     *
     * @param MailQueue $mail
     */
    protected function process($mail)
    {
        if (\Yii::$app->mailer->compose()
            ->setTo($mail->recipient)
            ->setFrom($mail->sender)
            ->setSubject($mail->subject)
            ->setHtmlBody($mail->content)
            ->send()) {
            if ($mail->del_after_send) {
                $mail->delete();
            } else {
                $mail->status = 'SUCCESS';
                $mail->save(false);
            }
        } else {
            if ($mail->try_send > 0) {
                $mail->updateCounters([
                    'try_send' => - 1
                ]);
            } else {
                $mail->status = 'ERROR';
                $mail->save(false);
            }
        }
    }

    protected function enableSendEmailer()
    {
        if (KitHelper::getSetting('email.host') && KitHelper::getSetting('email.username') && KitHelper::getSetting('email.password') && KitHelper::getSetting('email.port')) {
            return true;
        } else {
            return false;
        }
    }
}


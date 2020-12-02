<?php

namespace Backend\Tasks

use Backend\ModelslQueue;
use DuAdmin\Helpers\MAHelper;
use yii\base\BaseObject;

class SendMail extends BaseObject
{

    public function handle($params, $cron)
    {
        if ($mails = MailQueue::find()->where([
            'status' => 'TODO'
        ])
            ->limit(10)
            ->orderBy('id desc')
            ->all()
        ); {
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
            ->send()
        ) {
            //发送后删除
            if ($mail->del_after_send) {
                $mail->delete();
            } else {
                $mail->status = 'SUCCESS';
                $mail->save(false);
            }
        } else {
            // 重拾
            if ($mail->try_send > 0) {
                $mail->updateCounters([
                    'try_send' => -1
                ]);
            } else {
                $mail->status = 'ERROR';
                $mail->save(false);
            }
        }
    }

    protected function enableSendEmailer()
    {
        if (
            MAHelper::getSetting('email.host') &&
            MAHelper::getSetting('email.username') &&
            MAHelper::getSetting('email.password') &&
            MAHelper::getSetting('email.port')
        ) {
            return true;
        } else {
            return false;
        }
    }
}

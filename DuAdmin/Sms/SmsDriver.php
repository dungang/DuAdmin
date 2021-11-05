<?php

namespace DuAdmin\Sms;

interface SmsDriver
{

    /**
     * 发送
     * @param string $number
     * @param string $captcha
     * @return boolean
     */
    public function sendCaptcha($number, $captcha);


    /**
     * 发送
     * @param string $number
     * @param array $msg
     * @return boolean
     */
    public function sendMsg($number, $msg);
}

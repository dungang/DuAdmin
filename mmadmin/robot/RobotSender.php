<?php
namespace app\mmadmin\robot;

/**
 *
 * @author dungang
 */
interface RobotSender
{
    public function sendMessage($title,$msg);
}


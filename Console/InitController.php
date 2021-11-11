<?php

namespace Console;

use Backend\Models\Admin;
use yii\helpers\Console;
use yii\helpers\Inflector;

class InitController extends BaseController
{

    public function init()
    {
        parent::init();
        $this->mustDevCanDo();
    }

    /**
     * 安装系统数据
     *
     * @return void
     */
    public function actionIndex()
    {

        //生成key
        $this->run('/key-generate');
        //重装数据库
        $this->run('/migrate/fresh', [
            'migrationPath' => [
                '@app/migrations',
                '@Addons/Cms/Migrations',
                '@Addons/ChinaRegion/Migrations',
                '@Addons/Ueditor/Migrations',
            ]
        ]);
        //创建管理员
        $this->runAction('admin');
    }

    /**
     * 初始化管理员
     *
     * @return void
     */
    public function actionAdmin()
    {
        //设置账户密码
        $username = $this->prompt('please input admin name:', ['required' => true]);
        $password = $this->prompt('please input admin password:', ['required' => true]);
        $email = $this->prompt('please input admin email:', ['required' => true]);

        $admin = new Admin([
            'username' => $username,
            'nickname' => Inflector::camelize($username),
            'authKey' => \Yii::$app->security->generateRandomString(),
            'passwordHash' => \Yii::$app->security->generatePasswordHash($password),
            'email' => $email,
            'status' => 10,
            'isSuper' => 1,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);
        if ($admin->save(false)) {
            $this->stdout('Congratulations! Install Success!', Console::FG_GREEN);
        } else {
            $this->stdout("admin create failure!\n\n\n", Console::FG_RED);
        };
    }
}

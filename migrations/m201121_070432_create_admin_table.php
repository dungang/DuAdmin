<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin}}`.
 */
class m201121_070432_create_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(32)->unique()->notNull()->comment("用户名"),
            'nickname' => $this->string(32)->null()->comment('昵称'),
            'avatar' => $this->string(255)->null()->comment('头像'),
            'authKey' => $this->string(128)->null()->comment('授权KEY'),
            'passwordHash' => $this->string(128)->null()->comment('密码hash'),
            'passwordResetToken' => $this->string(128)->null()->comment('密码重置token'),
            'email' => $this->string(64)->null()->unique()->comment('邮箱'),
            'mobile' => $this->string(16)->null()->unique()->comment('手机'),
            'status' => $this->tinyInteger()->defaultValue(10)->comment('状态::0:未激活|10:已激活'),
            'isSuper' => $this->tinyInteger()->defaultValue(0)->comment('是否超管::0:普通成员|1:超级管理员'),
            'loginAt' => $this->timestamp()->null()->comment('上次登陆时间'),
            'loginFailure' => $this->string(255)->null()->comment('登陆失败消息'),
            'loginIp' => $this->string(64)->null()->comment('登录IP'),
            'createdAt' => $this->timestamp()->null()->comment('添加时间'),
            'updatedAt' => $this->timestamp()->null()->comment('更新时间'),
        ]);

        $this->insert('{{%admin}}',[
            'username' => 'admin',
            'nickname' => 'Admin',
            'authKey' => \Yii::$app->security->generateRandomString(),
            'passwordHash' => \Yii::$app->security->generatePasswordHash('admin'),
            'email' => 'admin@website',
            'status' => 10,
            'isSuper' => 1,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin}}');
    }
}

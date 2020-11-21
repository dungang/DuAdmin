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
            'auth_key' => $this->string(128)->null()->comment('授权KEY'),
            'password_hash' => $this->string(128)->null()->comment('密码hash'),
            'password_reset_token' => $this->string(128)->null()->comment('密码重置token'),
            'email' => $this->string(64)->null()->unique()->comment('邮箱'),
            'mobile' => $this->string(16)->null()->unique()->comment('手机'),
            'status' => $this->tinyInteger()->defaultValue(10)->comment('状态'),
            'is_super' => $this->tinyInteger()->defaultValue(0)->comment('是否超光'),
            'login_time' => $this->integer()->null()->comment('上次登陆时间'),
            'login_failure' => $this->string(255)->null()->comment('登陆失败消息'),
            'login_ip' => $this->string(64)->null()->comment('登录IP'),
            'created_at' => $this->integer()->null()->comment('添加时间'),
            'updated_at' => $this->integer()->null()->comment('更新时间'),
        ]);

        $this->insert('{{%admin}}',[
            'username' => 'admin',
            'nickname' => 'Admin',
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'password_hash' => \Yii::$app->security->generatePasswordHash('admin'),
            'email' => 'admin@website',
            'status' => 10,
            'is_super' => 1,
            'created_at' => time(),
            'updated_at' => time()
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

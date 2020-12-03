<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m201124_063347_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
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
            'login_at' => $this->timestamp()->null()->comment('上次登陆时间'),
            'login_failure' => $this->string(255)->null()->comment('登陆失败消息'),
            'login_ip' => $this->string(64)->null()->comment('登录IP'),
            'created_at' => $this->timestamp()->null()->comment('添加时间'),
            'updated_at' => $this->timestamp()->null()->comment('更新时间'),
        ]);
        
        $this->insert('{{%user}}',[
            'username' => 'da',
            'nickname' => 'DuJiaoPai',
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'password_hash' => \Yii::$app->security->generatePasswordHash('da'),
            'email' => 'djp@duadmin',
            'status' => 10,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}

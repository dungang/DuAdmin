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
            'id' => $this->bigPrimaryKey(),
            'username' => $this->string(32)->unique()->notNull()->comment("用户名"),
            'nickname' => $this->string(32)->null()->comment('昵称'),
            'avatar' => $this->string(255)->null()->comment('头像'),
            'authKey' => $this->string(128)->null()->comment('授权KEY'),
            'passwordHash' => $this->string(128)->null()->comment('密码hash'),
            'passwordResetToken' => $this->string(128)->null()->comment('密码重置token'),
            'email' => $this->string(64)->null()->unique()->comment('邮箱'),
            'mobile' => $this->string(16)->null()->unique()->comment('手机'),
            'status' => $this->tinyInteger()->defaultValue(10)->comment('状态'),
            'isSuper' => $this->tinyInteger()->defaultValue(0)->comment('是否创始用户'),
            'loginAt' => $this->dateTime()->null()->comment('上次登陆时间'),
            'loginFailure' => $this->string(255)->null()->comment('登陆失败消息'),
            'loginIp' => $this->string(64)->null()->comment('登录IP'),
            'createdAt' => $this->dateTime()->null()->comment('添加时间'),
            'updatedAt' => $this->dateTime()->null()->comment('更新时间'),
        ]);
        $this->addCommentOnTable('{{%user}}','用户');
        
        $this->insert('{{%user}}',[
            'username' => 'da',
            'nickname' => 'DuJiaoPai',
            'authKey' => \Yii::$app->security->generateRandomString(),
            'passwordHash' => \Yii::$app->security->generatePasswordHash('da'),
            'email' => 'djp@duadmin',
            'isSuper' =>1,
            'status' => 10,
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
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

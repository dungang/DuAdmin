<?php
use yii\db\Migration;
/**
 * Class m210110_051149_create_cms_link_tables
 */
class m210110_051149_create_cms_link_tables extends Migration {

  const TABLE_LINK = "{{%friend_link}}";

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    $this->createTable( static::TABLE_LINK, [
        'id' => $this->primaryKey(),
        'pid' => $this->integer()->defaultValue( 0 )->comment( 'PID' ),
        'name' => $this->string( 64 )->notNull()->comment( '名称' ),
        'type' => $this->string( 16 )->defaultValue( 'url' )->comment( '类型::url:链接|email:邮件|tel:电话|qrcode:二维码' ),
        'pic' => $this->string( 128 )->comment( '图片' ),
        'url' => $this->string( 128 )->comment( '网页地址' ),
        'sort' => $this->smallInteger()->defaultValue( 1 )->comment( '排序' ),
        'createdAt' => $this->dateTime()->null()->comment( '添加时间' ),
        'updatedAt' => $this->dateTime()->null()->comment( '更新时间' )
    ] );
    $this->addCommentOnTable( static::TABLE_LINK, "友情链接" );
    $this->batchInsert( static::TABLE_LINK, [
        'pid',
        'name',
        'url'
    ], [
        [
            0,
            '服务条款',
            '#'
        ],
        [
            0,
            '友情链接',
            '#'
        ],
        [
            1,
            '联系我们',
            '/contact-us'
        ],
        [
            1,
            '关于我们',
            '/about-us'
        ],
        [
            2,
            'YiiFramework',
            'https://www.yiiframework.com'
        ]
    ] );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    $this->dropTable( static::TABLE_LINK );

  }
  /*
   * // Use up()/down() to run migration code without a transaction.
   * public function up()
   * {
   *
   * }
   *
   * public function down()
   * {
   * echo "m210110_051149_create_cms_link_tables cannot be reverted.\n";
   *
   * return false;
   * }
   */
}
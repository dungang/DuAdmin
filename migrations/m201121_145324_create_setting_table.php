<?php

use DuAdmin\Models\Setting;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%setting}}`.
 */
class m201121_145324_create_setting_table extends Migration {

    public $tableName = '{{%setting}}';

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp() {

        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
        $this->createTable( $this->tableName, [
            'name'        => $this->string( 64 )->notNull()->comment( '变量名' ),
            'title'       => $this->string( 64 )->notNull()->comment( '变量标题' ),
            'value'       => $this->text()->null()->comment( '变量值' ),
            'valType'     => $this->string( 64 )->notNull()->comment( '值类型::IMAGE:图片|BOOL:Boolean|STR:字符串|ARRY:数组|ASSOC:关联数组|JSON:json字符串|HTML:html代码|P:段落' ),
            'hint'        => $this->string( 255 )->null()->comment( '变量介绍' ),
            'dictType'    => $this->string( 64 )->comment( "字典类型" ),
            'category'    => $this->string( 64 )
                ->notNull()
                ->defaultValue( 'system' )
                ->comment( '变量标题' ),
            'subCategory' => $this->string( 64 )
                ->comment( '变量子标题' ),
            ], $tableOptions );
        $this->addPrimaryKey( 'pk-setting-name', $this->tableName, 'name' );
        $this->addCommentOnTable( '{{%setting}}', '系统配置' );
        // 初始化配置
        $this->batchInsert( $this->tableName, [
            'name',
            'title',
            'value',
            'valType',
            'hint',
            'dictType',
            'subCategory'
            ], [
            [
                'site.name',
                '网站名称',
                'DUAdmin',
                'STR',
                '前台首页的网站名称',
                '',
                'base'
            ],
            [
                'site.logo',
                '网站Logo',
                'DUAdmin',
                'IMAGE',
                '前台首页的网站Logo',
                '',
                'base'
            ],
            [
                'site.company',
                '公司名称',
                '杭州达柚科技有限公司',
                'STR',
                '前台首页的企业名称',
                '',
                'base'
            ],
            [
                'site.phone',
                '联系电话',
                '15355498106',
                'STR',
                '前台首页的电话号码',
                '',
                'base'
            ],
            [
                'site.email',
                '电子邮箱',
                'dungang@126.com',
                'STR',
                '前台首页的邮箱地址',
                '',
                'base'
            ],
            [
                'site.enableRegister',
                '开放注册',
                0,
                'BOOL',
                '前台是否开放注册功能',
                '',
                'base'
            ],
            [
                'site.enableLogin',
                '开放登录',
                1,
                'BOOL',
                '前台是否开放登录功能',
                '',
                'base'
            ],
            [
                'site.keywords',
                '网站关键词',
                'DUAdmin,达柚, CMS, PHPAdmin, Yii2 fast kit',
                'STR',
                '搜索优化的关键词',
                '',
                'base'
            ],
            [
                'site.description',
                '网站介绍',
                'DUAdmin极速后台开发框架',
                'STR',
                '搜索优化的简介',
                '',
                'base'
            ],
            [
                'site.qr',
                '微信二维码',
                '',
                'IMAGE',
                '公众号二维码',
                '',
                'base'
            ],
            [
                'site.tongji',
                '网站统计',
                '',
                'STR',
                '网站的统计JS代码',
                '',
                'base'
            ],
            [
                'site.beian',
                '网站备案号',
                '浙ICP备2020044981号-2',
                'STR',
                '工信部网站备案号',
                '',
                'base'
            ],
            [
                'site.googleAdv',
                '谷歌自动广告',
                '',
                'STR',
                '谷歌广告JS代码',
                '',
                'base'
            ],
            [
                'email.host',
                '邮件服务器',
                'smtp.aliyun.com',
                'STR',
                '可以是域名或者是IP地址',
                '',
                'email'
            ],
            [
                'email.username',
                '邮件账号',
                'dungang2018@aliyun.com',
                'STR',
                '',
                '',
                'email'
            ],
            [
                'email.password',
                '邮件密码',
                '',
                'STR',
                '密码',
                '',
                'email'
            ],
            [
                'email.port',
                '邮件端口',
                '25',
                'STR',
                '邮件服务器端口',
                '',
                'email'
            ],
            [
                'email.userAlias',
                '邮件账号别名',
                'DUAdmin Tech',
                'STR',
                '邮件账号名称',
                '',
                'email'
            ],
            [
                'email.recipient',
                '收件账号',
                'dungang@126.com',
                'STR',
                '邮件账号',
                '',
                'email'
            ],
            [
                'email.recipientAlias',
                '收件账号别名',
                'DUAdmin Tech',
                'STR',
                '收件账号',
                '',
                'email'
            ],
            [
                'site.index-page',
                '网站首页地址',
                '',
                'STR',
                '可以根据业务配置网站的默认首页',
                '',
                'open-feature'
            ],
            [
                'system.storage.driver',
                '存储服务',
                '',
                'STR',
                '默认是本地存储',
                'system_storage',
                'open-feature'
            ],
            [
                'system.storage.extensions',
                '存储文件类型',
                'jpeg,jpg,png',
                'STR',
                '默认图片',
                '',
                'open-feature'
            ],
            [
                'uploader.allowExtensions',
                '上传文件扩展名',
                'jpg,jpeg,png',
                'ARRAY',
                '允许上传的文件后缀名',
                '',
                'open-feature'
            ],
            [
                'system.editor.driver',
                '默认编辑器',
                'Addons\Ueditor\Widgets\Ueditor',
                'STR',
                '百度编辑器',
                'system_editor',
                'open-feature'
            ]
        ] );
        Setting::updateAll( [
            'value' => 'var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?e2eccb33395fcbad8ddb84c18304aef3";
          var s = document.getElementsByTagName("script")[0];
          s.parentNode.insertBefore(hm, s);
        })();'
            ], [
            'name' => 'site.tongji'
        ] );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->dropTable( $this->tableName );
    }

}

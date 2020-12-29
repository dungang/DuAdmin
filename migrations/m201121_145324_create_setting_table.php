<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%setting}}`.
 */
class m201121_145324_create_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=MyISAM';
        $this->createTable('{{%setting}}', [
            'name' => $this->string(64)->notNull()->comment('变量名'),
            'parent'=> $this->string(64)->notNull()->comment('归属'),
            'title' => $this->string(64)->notNull()->comment('变量标题'),
            'value' => $this->text()->null()->comment('变量值'),
            'valType' => $this->string(64)->notNull()->comment('值类型::IMAGE:图片|BOOL:Boolean|STR:字符串|ARRY:数组|ASSOC:关联数组|JSON:json字符串|HTML:html代码|P:段落'),
            'hint' => $this->string(255)->null()->comment('变量介绍'),
            'category' => $this->string(64)->notNull()->defaultValue('base')->comment('变量标题')
        ],$tableOptions);
        $this->addPrimaryKey('pk-setting-name','{{%setting}}','name');
        $this->createIndex('idx-setting-parent', '{{%setting}}', 'parent');
        $this->addCommentOnTable('{{%setting}}', '系统配置');
        
        //初始化配置
        $this->batchInsert('{{%setting}}',
            ['name','parent','title','value','valType','hint','category'],
            [
                ['site.name','','网站名称','DuAdmin','STR','前台首页的网站名称','base'],
                ['site.logo','','网站Logo','DuAdmin','IMAGE','前台首页的网站Logo','base'],
                ['site.i18n','','网站支持的语言','en-US:English\r\nzh-CN:中文','ASSOC','前台首页的网站Logo','base'],
                ['site.company','','公司名称','DuAdmin Tech','STR','前台首页的企业名称','base'],
                ['site.phone','','联系电话','1555498106','STR','前台首页的电话号码','base'],
                ['site.email','','电子邮箱','dungang@126.com','STR','前台首页的邮箱地址','base'],
                ['site.enable-regist','','开放注册',0,'BOOL','前台是否开放注册功能','base'],
                ['site.enable-login','','开放登录',1,'BOOL','前台是否开放登录功能','base'],
                ['site.keywords','','网站关键词','DuAdmin, CMS, PHPAdmin, Yii2 fast kit','STR','搜索优化的关键词','base'],
                ['site.description','','网站介绍','极速开发后台框架','STR','搜索优化的简介','base'],
                ['site.tongji','','网站统计','','STR','网站的统计JS代码','base'],
                ['setting.category', '', '参数分类', "base:基本设置\r\nemail:邮件服务\r\nopen-feature:开放功能\r\n", 'ASSOC','每行代表一个关联数组元素，key:val格式',  'base'],
                ['email.host','', '邮件服务器', 'smtp.aliyun.com', 'STR', '可以是域名或者是IP地址', 'email'],
                ['email.username', '', '邮件账号', 'dungang2018@aliyun.com', 'STR', '', 'email'],
                ['email.password', '','邮件密码', '', 'STR', '', 'email'],
                ['email.port', '','邮件端口', '25','STR', '', 'email'],
                ['email.user-alias', '','邮件账号别名', 'DuAdmin Tech', 'STR', '', 'email'],
                ['email.recipient', '','收件账号', 'dungang@126.com', 'STR', '', 'email'],
                ['email.recipient-alias', '','收件账号别名', 'DuAdmin Tech', 'STR', '', 'email'],
                ['site.index-page','','网站首页地址','','STR','可以根据业务配置网站的默认首页', 'open-feature'],
                ['system.storage.driver','','存储服务','', 'STR', '默认是本地存储', 'open-feature'],
                ['sysltem.storate.local_driver','system.storage.driver','本地存储','DuAdmin\Storage\LocalDriver', 'STR', '本地存储，默认存在目录public/uploads','open-feature'],
                ['uploader.allow_extensions','', '上传文件扩展名', '.jpg,.png',  'ARRAY', '允许上传的文件后缀名','open-feature'],
                ['system.editor.driver','', '默认编辑器', 'Addons\Ueditor\Widgets\Ueditor',  'STR', '百度编辑器','open-feature'],
                ['system.flash.widget','', '默认轮播小部件', 'Frontend\Widgets\Swiper',  'STR', '修改位轮播小部件的类名','open-feature'],                
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%setting}}');
    }
}

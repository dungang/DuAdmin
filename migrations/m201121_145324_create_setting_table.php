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
        $this->createTable('{{%setting}}', [
            'name' => $this->string(64)->notNull()->comment('变量名'),
            'parent'=> $this->string(64)->notNull()->comment('归属'),
            'title' => $this->string(64)->notNull()->comment('变量标题'),
            'value' => $this->text()->null()->comment('变量值'),
            'val_type' => $this->string(64)->notNull()->comment('值类型'),
            'hint' => $this->string(255)->null()->comment('变量介绍'),
            'category' => $this->string(64)->notNull()->defaultValue('base')->comment('变量标题')
        ]);
        $this->addPrimaryKey('pk-setting-name','{{%setting}}','name');
        $this->createIndex('idx-setting-parent', '{{%setting}}', 'parent');
        $this->addCommentOnTable('{{%setting}}', '系统配置');
        
        //初始化配置
        $this->batchInsert('{{%setting}}',
            ['name','parent','title','value','val_type','hint','category'],
            [
                ['site.name','','网站名称','DUAdmin','STR','前台首页的网站名称','base'],
                ['site.logo','','网站Logo','DUAdmin','IMAGE','前台首页的网站Logo','base'],
                ['site.company','','公司名称','速麦科技','STR','前台首页的企业名称','base'],
                ['site.phone','','联系电话','1555498106','STR','前台首页的电话号码','base'],
                ['site.email','','电子邮箱','dungang@126.com','STR','前台首页的邮箱地址','base'],
                ['site.keywords','','网站关键词','DUAdmin, CMS, PHPAdmin, Yii2 fast kit','STR','搜索优化的关键词','base'],
                ['site.description','','网站介绍','极速开发后台框架','STR','搜索优化的简介','base'],
                ['site.tongji','','网站统计','','STR','网站的统计JS代码','base'],
                ['setting.category', '', '参数分类', "base:基本设置\r\nemail:邮件服务\r\nopen-feature:开放功能\r\n", 'ASSOC','每行代表一个关联数组元素，key:val格式',  'base'],
                ['email.host','', '邮件服务器', '', 'STR', '可以是域名或者是IP地址', 'email'],
                ['email.username', '', '邮件账号', '', 'STR', '', 'email'],
                ['email.password', '','邮件密码', '', 'STR', '', 'email'],
                ['email.port', '','邮件端口', '25','STR', '', 'email'],
                ['email.useralias', '','邮件账号别名', '速麦科技', 'STR', '', 'email'],
                ['site.index-page','','网站首页地址','','STR','可以根据业务配置网站的默认首页', 'open-feature'],
                ['system.storage.driver','','存储服务','', 'STR', '默认是本地存储', 'open-feature'],
                ['sysltem.storate.local_driver','system.storage.driver','本地存储','DuAdmin\\Storage\\LocalDriver', 'STR', '本地存储，默认存在目录public/uploads','open-feature'],
                ['uploader.allow_extensions','', '上传文件扩展名', '.jpg,.png',  'ARRAY', '允许上传的文件后缀名','open-feature'],
                ['system.editor.driver','', '默认编辑器', 'Addons\\Ueditor\\Widgets\\Ueditor',  'STR', '百度编辑器','open-feature'],
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

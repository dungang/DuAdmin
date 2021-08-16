<?php

use DuAdmin\Helpers\InstallerHelper;
use DuAdmin\Models\Setting;
use yii\db\Migration;

/**
 * Class m201224_134253_create_cms_settings
 */
class m201224_134253_create_cms_settings extends Migration
{

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {

        // 初始化配置参数
        InstallerHelper::installSettings( [
            [
                'name'    => 'cms.post.compress',
                'title'   => '文章图片是否压缩',
                'value'   => 'false',
                'valType' => 'STR'
            ],
            [
                'name'    => 'cms.post.clip',
                'title'   => '文章图片是否裁剪',
                'value'   => 'true',
                'valType' => 'STR'
            ],
            [
                'name'    => 'cms.post.clipHeight',
                'title'   => '文章图片高度',
                'value'   => '320',
                'valType' => 'STR'
            ],
            [
                'name'    => 'cms.post.clipWidth',
                'title'   => '文章图片的宽度',
                'value'   => '480',
                'valType' => 'STR'
            ],
            [
                'name'    => 'cms.flash.compress',
                'title'   => '轮播图片是否压缩',
                'value'   => 'false',
                'valType' => 'STR'
            ],
            [
                'name'    => 'cms.flash.clip',
                'title'   => '轮播图片是否裁剪',
                'value'   => 'false',
                'valType' => 'STR'
            ],
            [
                'name'    => 'cms.flash.clipHeight',
                'title'   => '轮播图片高度',
                'value'   => '375',
                'valType' => 'STR'
            ],
            [
                'name'    => 'cms.flash.clipWidth',
                'title'   => '轮播图片的宽度',
                'value'   => '1200',
                'valType' => 'STR'
            ],
        ], 'addon-cms' );
        Setting::updateAll( [
            'value' => 'Addons\Cms\Widgets\CmsPageFooter'
        ], [
            'name' => 'site.pageFooterWidget'
        ] );
        InstallerHelper::InstallDict( 'cms_post_template', '文章模板', [
            ['dictLabel' => '默认', 'dictValue' => 'post'],
            ['dictLabel' => '产品', 'dictValue' => 'product'],
        ] );
        InstallerHelper::installMenus( [
            [
                'name'     => '内容管理',
                'url'      => '#',
                'icon'     => 'fa fa-globe',
                'children' => [
                    [
                        'name' => '文章',
                        'url'  => 'cms/post',
                        'icon' => 'fa fa-file-powerpoint-o'
                    ],
                    [
                        'name' => '轮播',
                        'url'  => 'cms/flash',
                        'icon' => 'fa fa-film'
                    ],
                    [
                        'name' => '单页',
                        'url'  => 'cms/page',
                        'icon' => 'fa fa-flag'
                    ],
                    [
                        'name' => '分类',
                        'url'  => 'cms/category',
                        'icon' => 'fa fa-bars'
                    ],
                    [
                        'name' => '链接',
                        'url'  => 'cms/friend-link',
                        'icon' => 'fa fa-link'
                    ],
                    [
                        'name' => '广告位',
                        'url'  => 'cms/adv-block',
                        'icon' => 'fa fa-flag'
                    ]
                ]
            ]
        ], 0, 'addon-cms' );
        // insert base page
        $this->insert( '{{%cms_page}}', [
            'slug'   => 'about-us',
            'title'  => '关于我们',
            'isLive' => 0,
            'sort'   => 1
        ] );
        $this->insert( '{{%cms_page}}', [
            'slug'   => 'contact-us',
            'title'  => '联系我们',
            'isLive' => 0,
            'sort'   => 0
        ] );
        $this->insert( '{{%cms_page}}', [
            'slug'     => 'index',
            'title'    => '首页',
            'template' => 'empty',
            'isLive'   => 1,
            'sort'     => 2
        ] );
        $this->insert( '{{%cms_page_post}}', [
            'pageId'    => 1,
            'language'  => 'zh-CN',
            'title'     => '关于我们',
            'content'   => 'DuAdmin （中文：达柚管理后台） 是一个管理后台快速开发框架，基于Yii2框架开发^^!',
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' )
        ] );
        $this->insert( '{{%cms_page_post}}', [
            'pageId'    => 2,
            'language'  => 'zh-CN',
            'title'     => '联系我们',
            'content'   => 'QQ：568663174',
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' )
        ] );
        $this->insert( '{{%cms_page_post}}', [
            'pageId'    => 3,
            'language'  => 'zh-CN',
            'title'     => '首页',
            'content'   => '',
            'createdAt' => date( 'Y-m-d H:i:s' ),
            'updatedAt' => date( 'Y-m-d H:i:s' )
        ] );
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->delete( '{{%setting}}', [
            'category' => 'addon-cms'
        ] );
    }

}

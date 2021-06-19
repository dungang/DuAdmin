<?php
use DuAdmin\Helpers\InstallerHelper;
use DuAdmin\Models\Setting;
use yii\db\Migration;
/**
 * Class m201224_134253_create_cms_settings
 */
class m201224_134253_create_cms_settings extends Migration {

  /**
   *
   * {@inheritdoc}
   */
  public function safeUp() {

    // 初始化配置参数
    InstallerHelper::installSettings( [
        [
            'name' => 'cms.post.compress',
            'title' => '文章图片是否压缩',
            'value' => 'false',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.post.clip',
            'title' => '文章图片是否裁剪',
            'value' => 'true',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.post.clipHeight',
            'title' => '文章图片高度',
            'value' => '320',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.post.clipWidth',
            'title' => '文章图片的宽度',
            'value' => '480',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.post.templates',
            'title' => '文章显示模板',
            'value' => "post:文章\r\nproduct:产品",
            'valType' => 'ASSOC'
        ],
        [
            'name' => 'cms.flash.compress',
            'title' => '轮播图片是否压缩',
            'value' => 'false',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.flash.clip',
            'title' => '轮播图片是否裁剪',
            'value' => 'false',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.flash.clipHeight',
            'title' => '轮播图片高度',
            'value' => '375',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.flash.clipWidth',
            'title' => '轮播图片的宽度',
            'value' => '1200',
            'valType' => 'STR'
        ],
        [
            'name' => 'cms.flash.widget',
            'parent' => 'system.flash.widget',
            'title' => '轮播小部件',
            'value' => 'Addons\Cms\Widgets\Swiper',
            'valType' => 'STR',
            'hint' => '轮播小部件的类目'
        ],
        [
            'name' => 'cms.pageFooterWidget',
            'parent' => 'site.pageFooterWidget',
            'title' => 'CMS网站底部小部件',
            'value' => 'Addons\Cms\Widgets\CmsPageFooter',
            'valType' => 'STR'
        ]
    ], 'addon-cms' );
    Setting::updateAll( [
        'value' => 'Addons\Cms\Widgets\CmsPageFooter'
    ], [
        'name' => 'site.pageFooterWidget'
    ] );
    InstallerHelper::installMenus( [
        [
            'name' => '内容管理',
            'url' => '#',
            'icon' => 'fa fa-globe',
            'children' => [
                [
                    'name' => '文章',
                    'url' => 'cms/post',
                    'icon' => 'fa fa-file-powerpoint-o'
                ],
                [
                    'name' => '轮播',
                    'url' => 'cms/flash',
                    'icon' => 'fa fa-film'
                ],
                [
                    'name' => '单页',
                    'url' => 'cms/page',
                    'icon' => 'fa fa-flag'
                ],
                [
                    'name' => '分类',
                    'url' => 'cms/category',
                    'icon' => 'fa fa-bars'
                ],
                [
                    'name' => '链接',
                    'url' => 'cms/friend-link',
                    'icon' => 'fa fa-link'
                ]
            ]
        ]
    ], 0, 'addon-cms' );
    InstallerHelper::installPageBlocks( [
        [
            'name' => 'CMS巨幕',
            'widget' => 'Addons\Cms\Widgets\JumbotronBlock'
        ],
        [
            'name' => 'CMS轮播',
            'widget' => 'Addons\Cms\Widgets\SwiperBlock'
        ],
        [
            'name' => 'CMS-bootstrap轮播',
            'widget' => 'Addons\Cms\Widgets\FlashCarouselBlock'
        ],
        [
            'name' => 'CMS图文Grid',
            'widget' => 'Addons\Cms\Widgets\NewestPostsBlock'
        ]
    ], 'addon-cms' );
    // insert base page
    $this->insert( '{{%page}}', [
        'slug' => 'about-us',
        'title' => '关于我们',
        'sort' => 1
    ] );
    $this->insert( '{{%page}}', [
        'slug' => 'contact-us',
        'title' => '联系我们',
        'sort' => 0
    ] );
    $this->insert( '{{%page_post}}', [
        'pageId' => 1,
        'language' => 'zh-CN',
        'title' => '关于我们',
        'content' => 'DuAdmin （中文：独角派管理后台） 是一个管理后台快速开发框架，基于Yii2框架开发。Du是独的发音，独角兽的意思，我们更多想表达的意思是，希望是使用我们的后台程序的公司，以后都都能成为独角兽 ^^!',
        'createdAt' => date( 'Y-m-d H:i:s' ),
        'updatedAt' => date( 'Y-m-d H:i:s' )
    ] );
    $this->insert( '{{%page_post}}', [
        'pageId' => 2,
        'language' => 'zh-CN',
        'title' => '联系我们',
        'content' => 'QQ：568663174',
        'createdAt' => date( 'Y-m-d H:i:s' ),
        'updatedAt' => date( 'Y-m-d H:i:s' )
    ] );

  }

  /**
   *
   * {@inheritdoc}
   */
  public function safeDown() {

    $this->delete( '{{%setting}}', [
        'category' => 'addon-cms'
    ] );

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
   * echo "m201224_134253_create_cms_settings cannot be reverted.\n";
   *
   * return false;
   * }
   */
}
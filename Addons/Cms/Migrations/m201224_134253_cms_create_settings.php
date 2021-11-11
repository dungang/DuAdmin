<?php

use DuAdmin\Helpers\InstallerHelper;
use DuAdmin\Models\Setting;
use Console\components\Migration;

/**
 * Class m201224_134253_create_cms_settings
 */
class m201224_134253_cms_create_settings extends Migration
{

    /**
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //美化url

        InstallerHelper::installPrettyUrl('内容文章美化', 'cms/post/show', 'cms/post/show-<id:\d+>', 100);

        // 初始化配置参数
        InstallerHelper::installSettings([
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
        ], 'addon-cms');
        Setting::updateAll([
            'value' => 'Addons\Cms\Widgets\CmsPageFooter'
        ], [
            'name' => 'site.pageFooterWidget'
        ]);
        InstallerHelper::InstallDict('cms_post_template', '文章模板', [
            ['dictLabel' => '默认', 'dictValue' => 'post'],
            ['dictLabel' => '产品', 'dictValue' => 'product'],
        ]);
        InstallerHelper::installMenus([
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
                    ],
                    [
                        'name' => '设置',
                        'url'  => 'cms/setting',
                        'icon' => 'fa fa-gear'
                    ],
                ]
            ]
        ], 0, 'addon-cms');
        // insert base page
        $this->insert('{{%cms_page}}', [
            'slug'   => 'about-us',
            'title'  => '关于我们',
            'sort'   => 1
        ]);
        $this->insert('{{%cms_page}}', [
            'slug'   => 'contact-us',
            'title'  => '联系我们',
            'sort'   => 0
        ]);
        $this->insert('{{%cms_page}}', [
            'slug'     => 'index',
            'title'    => '首页',
            'sort'     => 2
        ]);
        $this->insert('{{%cms_page_post}}', [
            'pageId'    => 1,
            'language'  => 'zh-CN',
            'title'     => '关于我们',
            'content'   => '<div id="6120ca501624f" class="du-live-layout" data-page-block-id="20" data-page-block-class="Addons\Cms\PageBlock\Layouts\HomeBanners\HomeBanner" data-params="[]" data-options="[]">
            <div class="home-banner du-live-element img-holder" style="background-image: url(&quot;/images/earth.jpg&quot;); height: 240px;">
                        <div class="container">
                            <div class="du-live-element-layout ui-sortable">
                                <h1 class="du-live-element"><div style="text-align: center;"><span style="color: inherit; font-family: inherit;">关于我们</span></div></h1>
                                <p class="du-live-element"><div style="text-align: center;">我们的成长需要您更多的关注，感谢您！</div></p>
                            </div>
                        </div>
                    </div>
                    </div>
            
            <style>
            .home-banner.img-holder {
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
            }
            
            .home-banner .container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                color: white;
                height: 100%;
            }
            </style>',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);
        $this->insert('{{%cms_page_post}}', [
            'pageId'    => 2,
            'language'  => 'zh-CN',
            'title'     => '联系我们',
            'content'   => '<div id="6120ca501624e" class="du-live-layout ui-sortable" data-page-block-id="20" data-page-block-class="Addons\Cms\PageBlock\Layouts\HomeBanners\HomeBanner" data-params="[]" data-options="[]">
            <div class="home-banner du-live-element img-holder" style="background-image: url(&quot;/images/work.jpg&quot;); height: 240px;">
                        <div class="container">
                            <div class="du-live-element-layout">
                                <h1 class="du-live-element"><div style="text-align: center;"><span style="color: inherit; font-family: inherit;">联系我们</span></div></h1>
                                <p class="du-live-element"><div style="text-align: center;">一次沟通足够我们开心一年，联系我们让我们一起快乐！</div></p>
                            </div>
                        </div>
                    </div>
                    </div>
            <div id="6120cfb676b10" class="du-live-layout" data-page-block-id="4" data-page-block-class="Addons\Cms\PageBlock\Layouts\InfoBlock\InfoBlock2" data-params="[]" data-options="[]"><div class="du-live-layout" style="background-color: white; padding-top: 30px; padding-bottom: 30px;">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-offset-3 col-md-offset-3 col-sm-6 col-md-6">
                            <div class="du-live-element-layout section-head-info">
                                <h2 class="du-live-element">商务合作</h2>
                                <p class="du-live-element wow fadeInUp" style="visibility: visible;"><div style="text-align: left;">电话：15355498106</div><div style="text-align: left;">邮箱：dungang@126.com</div></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div></div>
            
            
            <style>
            .element-section .col-md-6 {
                height: 200px;
            }
            
            .element-section .img-holder {
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
                height: 100%;
            }
            
            .section-head-info {
                padding: 30px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            
            .element-section-info {
                padding: 30px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                text-align: left;
                background-color: white;
            }
            
            
            /* 小屏幕（平板，大于等于 768px） */
            
            @media (min-width: 768px) {
                .element-section .col-md-6 {
                    height: 250px;
                }
            }
            
            
            /* 中等屏幕（桌面显示器，大于等于 992px） */
            
            @media (min-width: 992px) {
                .element-section .col-md-6 {
                    height: 300px;
                }
            }
            
            
            /* 大屏幕（大桌面显示器，大于等于 1200px） */
            
            @media (min-width: 1260px) {
                .element-section .col-md-6 {
                    height: 400px;
                }
            }.home-banner.img-holder {
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
            }
            
            .home-banner .container {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                color: white;
                height: 100%;
            }
            </style>',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);
        $this->insert('{{%cms_page_post}}', [
            'pageId'    => 3,
            'language'  => 'zh-CN',
            'title'     => '首页',
            'content'   => '<div id="6120d19d07a4a" class="du-live-layout" infinite="" autoplay="" speed="500" fade="" cssease="linear" data-page-block-dynamic="" data-page-block-class="Addons\Cms\PageBlock\Layouts\Carousel\Carousel" data-params="{&quot;size&quot;:5}" data-options="{&quot;infinite&quot;:true,&quot;autoplay&quot;:true,&quot;speed&quot;:500,&quot;fade&quot;:true,&quot;arrows&quot;:false,&quot;cssEase&quot;:&quot;linear&quot;}"><div class="swiper-container slick-initialized slick-slider">
            <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 1185px;"><div class="swiper-slide slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" tabindex="0" style="width: 1185px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;"><img class="lazyload" src="/images/computer.jpg" alt="demo"></div></div></div>
        </div></div><div id="6120d1a3e880e" class="du-live-layout" data-page-block-id="10" data-page-block-class="Addons\Cms\PageBlock\Layouts\Container\Container" data-params="[]" data-options="[]" style="padding-bottom: 30px; background-image: url(&quot;images/grid-bg.jpg&quot;); background-size: cover; background-repeat: no-repeat; background-position: center center;"><div class="container">
            <div class="du-live-element-layout">
                <div id="6120d1e6e2994" class="du-live-layout" data-page-block-id="4" data-page-block-class="Addons\Cms\PageBlock\Layouts\InfoBlock\InfoBlock2" data-params="[]" data-options="[]"><div class="du-live-layout">
            <div class="container">
                <div class="row">
                    <div class="col-sm-offset-3 col-md-offset-3 col-sm-6 col-md-6">
                        <div class="du-live-element-layout section-head-info">
                            <h2 class="du-live-element">Hello DUAdmin!</h2>
                            <p class="du-live-element wow fadeInUp" style="visibility: visible;">
                                DUAdmin是一个YII2的应用后台开发框架系统.DUAdmin是一个YII2的应用后台开发框架系统.DUAdmin是一个YII2的应用后台开发框架系统.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div></div><div id="6120d1b2ca280" class="du-live-layout" data-page-block-id="16" data-page-block-class="Addons\Cms\PageBlock\Layouts\Columns\Column4" data-params="[]" data-options="[]"><div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="du-live-element-layout">
                        <div id="6120d1b8ce9a1" class="du-live-element" data-page-block-id="22" data-page-block-class="Addons\Cms\PageBlock\Elements\Image\ImageInfo" data-params="[]" data-options="[]"><div class="thumbnail ease-underline image-scale">
            <div class="image-scale-box">
                <img src="/images/computer.jpg" alt="图片">
            </div>
            <div class="caption">
                <h3 class="du-live-element">Thumbnail label</h3>
                <p class="du-live-element">Thumbnail label</p>
                <p class="du-live-element">
                    <a href="#" class="btn btn-primary" role="button">Button</a>
                </p>
            </div>
        </div>
        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="du-live-element-layout">
                        <div id="6120d1bcdc7d2" class="du-live-element" data-page-block-id="22" data-page-block-class="Addons\Cms\PageBlock\Elements\Image\ImageInfo" data-params="[]" data-options="[]"><div class="thumbnail ease-underline image-scale">
            <div class="image-scale-box">
                <img src="/images/computer.jpg" alt="图片">
            </div>
            <div class="caption">
                <h3 class="du-live-element">Thumbnail label</h3>
                <p class="du-live-element">Thumbnail label</p>
                <p class="du-live-element">
                    <a href="#" class="btn btn-primary" role="button">Button</a>
                </p>
            </div>
        </div>
        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="du-live-element-layout">
                        <div id="6120d1bff3cbf" class="du-live-element" data-page-block-id="22" data-page-block-class="Addons\Cms\PageBlock\Elements\Image\ImageInfo" data-params="[]" data-options="[]"><div class="thumbnail ease-underline image-scale">
            <div class="image-scale-box">
                <img src="/images/computer.jpg" alt="图片">
            </div>
            <div class="caption">
                <h3 class="du-live-element">Thumbnail label</h3>
                <p class="du-live-element">Thumbnail label</p>
                <p class="du-live-element">
                    <a href="#" class="btn btn-primary" role="button">Button</a>
                </p>
            </div>
        </div>
        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="du-live-element-layout">
                        <div id="6120d1c356deb" class="du-live-element" data-page-block-id="22" data-page-block-class="Addons\Cms\PageBlock\Elements\Image\ImageInfo" data-params="[]" data-options="[]"><div class="thumbnail ease-underline image-scale">
            <div class="image-scale-box">
                <img src="/images/computer.jpg" alt="图片">
            </div>
            <div class="caption">
                <h3 class="du-live-element">Thumbnail label</h3>
                <p class="du-live-element">Thumbnail label</p>
                <p class="du-live-element">
                    <a href="#" class="btn btn-primary" role="button">Button</a>
                </p>
            </div>
        </div>
        </div>
                    </div>
                </div>
            </div>
        </div></div>
            </div>
        </div></div>
        
        
        
        <style>
        .element-section .col-md-6 {
            height: 200px;
        }
        
        .element-section .img-holder {
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
        }
        
        .section-head-info {
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .element-section-info {
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: left;
            background-color: white;
        }
        
        
        /* 小屏幕（平板，大于等于 768px） */
        
        @media (min-width: 768px) {
            .element-section .col-md-6 {
                height: 250px;
            }
        }
        
        
        /* 中等屏幕（桌面显示器，大于等于 992px） */
        
        @media (min-width: 992px) {
            .element-section .col-md-6 {
                height: 300px;
            }
        }
        
        
        /* 大屏幕（大桌面显示器，大于等于 1200px） */
        
        @media (min-width: 1260px) {
            .element-section .col-md-6 {
                height: 400px;
            }
        }
        </style>',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     *
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->delete('{{%setting}}', [
            'category' => 'addon-cms'
        ]);
    }
}

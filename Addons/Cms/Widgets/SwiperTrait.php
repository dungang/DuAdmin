<?php
namespace Addons\Cms\Widgets;

use DuAdmin\Assets\SwiperAsset;
use yii\web\JsExpression;
use yii\helpers\Json;

trait SwiperTrait
{

    public $clientOptions = [
        'speed' => 1500
    ];

    public $selector = '.swiper-container';

    /**
     * 分页器
     *
     * @var boolean
     */
    public $pagination = false;

    /**
     * 导航按钮
     *
     * @var boolean
     */
    public $navigation = false;

    /**
     * 滚动条
     *
     * @var boolean
     */
    public $scrollbar = false;

    /**
     * 自动滑动
     *
     * @var boolean
     */
    public $autoplay = true;

    /**
     * 循环播放
     *
     * @var boolean
     */
    public $loop = true;

    /**
     * 最多数量
     *
     * @var integer
     */
    public $size = 5;

    /**
     * 条目
     *
     * @var array
     */
    public $items;

    public function settingSwiper()
    {
        SwiperAsset::register($this->view);
        if ($this->pagination) {
            $this->clientOptions['pagination'] = [
                'el' => '.swiper-pagination'
            ];
        }
        if ($this->navigation) {
            $this->clientOptions['navigation'] = [
                'nextEl' => '.swiper-button-next',
                'prevEl' => '.swiper-button-prev'
            ];
        }
        if ($this->scrollbar) {
            $this->clientOptions['scrollbar'] = [
                'el' => '.swiper-scrollbar'
            ];
        }

        $this->clientOptions['autoplay'] = $this->autoplay;
        $this->clientOptions['loop'] = $this->loop;

        $this->view->registerJs(new JsExpression("new Swiper('$this->selector'," . Json::encode($this->clientOptions) . ");"));
    }
}
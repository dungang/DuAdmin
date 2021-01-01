<?php
namespace Frontend\Widgets;

use DuAdmin\Widgets\DefaultFlashSwiper;
use DuAdmin\Assets\SwiperAsset;
use Yii;
use yii\helpers\FileHelper;
use yii\web\JsExpression;
use yii\helpers\Json;

class Swiper extends DefaultFlashSwiper
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

    public function run()
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
        $files = FileHelper::findFiles(Yii::getAlias('@root/public/images/screen/'),['recursive'=>false]);
        if($files) {
            $files = array_map(function($file){
                return 'images/screen/' . basename($file);
            },$files);
        } else {
            $files = [];
        }
        return $this->render('swiper',['files'=>$files]);
    }
}


<?php
namespace app\kit\widgets;

use yii\bootstrap\Widget;
use app\kit\assets\SlickCarouselAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Json;

class SlickCarousel extends Widget
{
    public $selector = '.swiper-container';
    
    public function run()
    {
        SlickCarouselAsset::register($this->view);
        $this->registerPlugin('slick');
    }
    
    /**
     * Registers a specific Bootstrap plugin and the related events
     * @param string $name the name of the Bootstrap plugin
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();
        
        BootstrapPluginAsset::register($view);
        
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('$this->selector').$name($options);";
            $view->registerJs($js);
        }
        
        $this->registerClientEvents();
    }
    
    /**
     * Registers JS event handlers that are listed in [[clientEvents]].
     * @since 2.0.2
     */
    protected function registerClientEvents()
    {
        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('$this->selector').on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }
}


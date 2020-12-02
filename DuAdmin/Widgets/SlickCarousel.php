<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\Widget;
use DuAdmin\Assets\SlickCarouselAsset;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Json;
use yii\helpers\Html;

class SlickCarousel extends Widget
{
    public $selector = '.swiper-container';
    
    public $tagName = 'div';
    
    /**
     * item模板
     * @var string
     */
    public $template = "{field}";
    
    /**
     * 元素集合
     * @var array
     */
    public $items = null;
    
    public function run()
    {
        SlickCarouselAsset::register($this->view);
        if($this->items) {
            $lines = [];
            foreach($this->items as $item) {
                $lines[] = preg_replace_callback('/\{(\w+)\}/i', function($match) use ($item) {
                    return $item[$match[1]];
                }, $this->template);
            }
            echo Html::tag($this->tagName,implode("\n", $lines),['class'=>ltrim($this->selector,'.')]);
        }
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


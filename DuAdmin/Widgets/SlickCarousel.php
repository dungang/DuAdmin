<?php

namespace DuAdmin\Widgets;

use DuAdmin\Assets\SlickCarouselAsset;
use DuAdmin\Core\BizException;
use yii\bootstrap\BootstrapPluginAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * http://kenwheeler.github.io/slick/
 *
 * @author dungang
 *
 */
class SlickCarousel extends Widget
{

    public $className = 'swiper-container';

    public $slideClassName = 'swiper-slide';

    public $viewName;

    /**
     * 元素集合
     *
     * @var array
     */
    public $items = null;

    public function run()
    {

        if ( empty( $this->viewName ) ) {
            throw new BizException( "SlickCarousel: 请设置模板文件路径" );
        }
        $this->clientOptions = ArrayHelper::merge( [
            'infinite' => true,
            'autoplay' => true,
            'speed'    => 500,
            'fade'     => true,
            'arrows'   => false,
            'cssEase'  => 'linear'], $this->clientOptions );
        SlickCarouselAsset::register( $this->view );
        $this->registerPlugin( 'slick' );
        return $this->render( $this->viewName, [
            'models' => $this->items,
            'widget' => $this] );

    }

    /**
     * Registers a specific Bootstrap plugin and the related events
     *
     * @param string $name
     *          the name of the Bootstrap plugin
     */
    protected function registerPlugin( $name )
    {

        $view = $this->getView();
        BootstrapPluginAsset::register( $view );
        if ( $this->clientOptions !== false ) {
            $options = empty( $this->clientOptions ) ? '' : Json::htmlEncode( $this->clientOptions );
            $selector = '.' . $this->className;
            $js = "jQuery('$selector').$name($options);";
            $view->registerJs( $js );
        }
        $this->registerClientEvents();

    }

    /**
     * Registers JS event handlers that are listed in [[clientEvents]].
     *
     * @since 2.0.2
     */
    protected function registerClientEvents()
    {

        if ( !empty( $this->clientEvents ) ) {
            $js = [];
            foreach ( $this->clientEvents as $event => $handler ) {
                $js[] = "jQuery('$this->selector').on('$event', $handler);";
            }
            $this->getView()->registerJs( implode( "\n", $js ) );
        }

    }
}


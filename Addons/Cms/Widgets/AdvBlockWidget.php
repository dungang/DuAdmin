<?php

namespace Addons\Cms\Widgets;

use Addons\Cms\Models\AdvBlock;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * 广告位置输出
 *
 * @author dungang
 *
 */
class AdvBlockWidget extends Widget {

    public $nameCode;
    public $urlPath;

    public function run() {

        if ( $this->urlPath ) {
            $adv = AdvBlock::findOne( [
                    'nameCode' => $this->nameCode,
                    'urlPath'  => $this->urlPath
                ] );
        } else {
            $adv = AdvBlock::findOne( [
                    'nameCode' => $this->nameCode
                ] );
        }
        $content = null;
        if ( $adv ) {
            $content = $adv->content;
            if ( $adv->type == 'image' ) {
                $content = $this->renderImage( $adv );
            } elseif ( $adv->type == 'google-adv' ) {
                $this->registGoogleAdvAsset();
                return $content;
            }
        }
        if ( empty( $content ) ) {
            return $content;
        } else {
            $content = Html::tag( 'div', $content, [
                    'class' => 'adv-block-' . $this->nameCode
                ] );
            if ( $adv->isFlat ) {
                return $content;
            } else {
                return Html::tag( 'div', $content, [
                        'class' => 'container'
                    ] );
            }
        }
    }

    public function registGoogleAdvAsset() {
        $this->view->registerJsFile( "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", [ 'async' => 'async' ] );
        $googleJs = <<<JS
if (!(/iphone|ipod|ipad|Android|nokia|blackberry|webos|webmate|bada|lg|ucweb|skyfire|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|wap|mobile/i.test(navigator.userAgent.toLowerCase()))) {
    (adsbygoogle = window.adsbygoogle || []).push({});
}
JS;

        $this->view->registerJs( $googleJs );
    }

    /**
     *
     * @param AdvBlock $adv
     */
    public function renderImage( $adv ) {

        $img = Html::img( $adv->pic );
        if ( $adv->url ) {
            return Html::a( $img, $adv->url );
        } else {
            return $img;
        }
    }

}

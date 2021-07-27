<?php


namespace Addons\Cms\PageBlock;


use yii\base\BaseObject;
use yii\helpers\Html;

abstract class BaseBlockWidget extends BaseObject
{


    public static $cssFiles = [];

    public static $jsFiles = [];

    public $basePath;

    public $jsFile;

    public $cssFile;

    public $iconFile;

    public $codeFile;

    public $id;
    /**
     * @var int
     */
    public $pageBlockId;

    public $type = 'layout';

    public function init()
    {
        if ( empty( $this->id ) ) {
            $this->id = uniqid();
        }
    }

    public function registerAssets()
    {

        if ( $this->jsFile ) {
            $jsFile = $this->basePath . '/' . $this->jsFile;
            static::$jsFiles[ md5( $jsFile ) ] = $jsFile;
        }
        if ( $this->cssFile ) {
            $cssFile = $this->basePath . '/' . $this->cssFile;
            static::$cssFiles[ md5( $cssFile ) ] = $cssFile;
        }
    }

    /**
     * 元素的图标图片
     * @return string|null
     */
    public function renderIcon()
    {
        \Yii::$app->getResponse()->sendFile( $this->basePath . "/" . $this->iconFile );

    }

    protected function prepareLiveCode()
    {
        return $this->renderCodeFile();;
    }

    public function renderCodeFile( $data = [] )
    {
        compact( $data );
        ob_start();
        ob_implicit_flush( false );
        require $this->basePath . '/' . $this->codeFile;
        $out = ob_get_contents();
        ob_clean();
        return  $out;
    }

    public function renderCssFile( $file )
    {
        if ( $file ) {
            return Html::tag( "style", file_get_contents( $this->basePath . '/' . $file ) );
        }
        return '';
    }

    public function renderJsFile( $file )
    {
        if ( $file ) {
            return Html::tag( "javascript", file_get_contents( $this->basePath . '/' . $file ) );
        }
        return '';
    }

    public function renderLiveCode()
    {
        return $this->renderCssFile( $this->cssFile )
            . Html::tag( 'div', $this->prepareLiveCode(),
                [
                    'id'                 => $this->id,
                    'class'              => 'du-live-' . $this->type,
                    'data-page-block-id' => $this->pageBlockId
                ] )
            . $this->renderJsFile( $this->jsFile );
    }

    public static function assets()
    {
        $widget = \Yii::createObject( get_called_class() );
        return call_user_func( [$widget, 'registerAssets'] );
    }

    public static function combineAssets()
    {
        $cssCode = '';
        foreach ( static::$cssFiles as $css ) {
            $cssCode .= file_get_contents( $css );
        }
        $style = '';
        if ( $cssCode ) {
            $style = "<style>\n" . $cssCode . "\n</style>";
        }
        $jsCode = '';
        foreach ( static::$jsFiles as $js ) {
            $jsCode .= file_get_contents( $js );
        }
        $script = '';
        if ( $jsCode ) {
            $style = "<script>\n" . $jsCode . "\n</script>";
        }
        return $style . "\n" . $script;
    }

    public static function icon()
    {
        $widget = \Yii::createObject( get_called_class() );
        return call_user_func( [$widget, 'renderIcon'] );
    }

    public static function code( $config = [] )
    {
        $config[ 'class' ] = get_called_class();
        $widget = \Yii::createObject( $config );
        return call_user_func( [$widget, 'renderLiveCode'] );
    }
}
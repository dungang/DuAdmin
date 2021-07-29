<?php


namespace Addons\Cms\PageBlock;


use yii\base\BaseObject;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * PageBlock基类
 * Class BaseBlockWidget
 * @package Addons\Cms\PageBlock
 */
abstract class BaseBlockWidget extends Widget
{

    public static $jsAsssets = [];

    public static $cssAssets = [];

    public $js = [];

    public $css = [];

    /**
     * 注册的所有的样式文件
     * @var array
     */
    public static $cssFiles = [];

    /**
     * @var array 注册的所有的js文件
     */
    public static $jsFiles = [];

    /**
     * @var string 小部件块所在的目录
     */
    public $basePath;

    /**
     * @var string 小部件使用的js文件
     */
    public $jsFile;

    /**
     * @var string 小部件使用的样式文件
     */
    public $cssFile;

    /**
     * @var string 小部件的图标
     */
    public $iconFile;

    /**
     * @var string 小部件的代码文件
     */
    public $codeFile;

    /**
     * @var string 小部件渲染的ID，自动生成
     */
    public $id;

    /**
     * @var int
     */
    public $pageBlockId;

    public $type = 'layout';

    public $isDynamic = false;

    /**
     * @var array 动态数据的参数
     */
    public $params = [];

    /**
     * @var array jquery plugin的参数
     */
    public $options = [];

    public function init()
    {
        if ( empty( $this->id ) ) {
            $this->id = uniqid();
        }
    }

    public function registerAllAssetsCode()
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
//        compact( $data );
//        ob_start();
//        ob_implicit_flush( false );
//        require $this->basePath . '/' . $this->codeFile;
//        $out = ob_get_clean();
//        return $out;
        return $this->render( $this->codeFile, $data );
    }

    public function registerAssetsCode()
    {
        if ( $this->jsFile ) {
            \Yii::$app->view->registerJs( file_get_contents( $this->basePath . '/' . $this->jsFile ) );
        }
        if ( $this->cssFile ) {
            \Yii::$app->view->registerCss( file_get_contents( $this->basePath . '/' . $this->cssFile ) );

        }
    }

    public function registerAssets()
    {
    }


    public function renderLiveCode()
    {
        $this->registerAssets();
        $this->registerAssetsCode();
        return Html::tag( 'div', $this->prepareLiveCode(),
            [
                'id'                      => $this->id,
                'class'                   => 'du-live-' . $this->type,
                'data-page-block-id'      => $this->pageBlockId,
                'data-page-block-dynamic' => $this->isDynamic,
                'data-page-block-class'   => get_called_class(),
                'data-params'             => Json::htmlEncode( $this->params ),
                'data-options'            => Json::htmlEncode( $this->options )
            ] );
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
            $script = "<script>\n" . $jsCode . "\n</script>";
        }
        return $style . "\n" . $script;
    }

    public static function registerBlockAssets()
    {
        $widget = \Yii::createObject( get_called_class() );
        return call_user_func( [$widget, 'registerAssets'] );
    }

    public static function assets()
    {
        $widget = \Yii::createObject( get_called_class() );
        return call_user_func( [$widget, 'registerAllAssetsCode'] );
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
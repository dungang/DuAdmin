<?php


namespace Addons\Cms\Controllers\Backend;

use Addons\Cms\Models\PageBlock;
use Addons\Cms\Models\PagePost;
use Addons\Cms\PageBlock\ElementSection\PlaceHolder;
use yii\web\NotFoundHttpException;

/**
 * 在线编辑控制器
 * Class LiveEditorController
 * @package Addons\Cms\Controllers\Backend
 */
class LiveEditorController extends \DuAdmin\Core\BackendController
{

    public function init()
    {
        parent::init();
        $this->layout = false;
    }

    /**
     * 加载在线编辑器
     * @param $pageId
     * @param string $language
     * @return string
     */
    public function actionIndex( $pageId, $language = 'zh-CN' )
    {
        $fields = ['pageId' => $pageId, 'language' => $language];
        $pagePost = PagePost::findOne( $fields );
        if ( empty( $pagePost ) ) {
            $pagePost = new PagePost( $fields );
        }
        return $this->render( 'index', ['model' => $pagePost] );
    }

    public function actionSave( $pageId, $language = 'zh-CN' )
    {

        $fields = ['pageId' => $pageId, 'language' => $language];
        $model = PagePost::findOne( $fields );
        if ( empty( $model ) ) {
            $model = new PagePost( $fields );
        }
        if ( $model->load( \Yii::$app->request->post() ) ) {
            $model->content = $this->clearAssets( $model->content );
            $model->content = $this->refreshAssets( $model->content );
            if ( $model->save() ) {
                return $this->asJson( [
                    'message' => "修改成功",
                    'data'    => [
                        'pageId'   => $model->pageId,
                        'language' => $model->language
                    ]

                ] );
            }
        }
        return $this->render( 'update', [
            'model' => $model
        ] );
    }

    /**
     * @param $content
     * @return string|string[]|null
     */
    private function clearAssets( $content )
    {
        $reg = '#<(script|style)(.*?)>(.*?)</(script|style)\s*>#ims';
        return preg_replace( $reg, '', $content );
    }

    /**
     * @param $content
     * @return mixed|string
     */
    private function refreshAssets( $content )
    {
        $reg = '#data\-page\-block\-id=["\'](\d+?)["\']#im';
        if ( preg_match_all( $reg, $content, $matches ) ) {
            $blockIds = array_unique( $matches[ 1 ] );
            $blocks = PageBlock::findAll( ['id' => $blockIds] );
            $assets = '';
            foreach ( $blocks as $block ) {
                $assetClass = $block->namespace . '\Asset';
                if ( class_exists( $assetClass ) ) {
                    $assets .= call_user_func( [$assetClass, 'widget'] );
                }
            }
            $content .= $assets;
        }
        return $content;
    }

    /**
     * 加载占位
     * @param $id
     * @return false|mixed
     */
    public function actionLoadPlaceHolder( $id )
    {
        $block = PageBlock::findOne( $id );
        $class = $block->namespace . '\PlaceHolder';
        return call_user_func( [$class, 'widget'], ['id' => uniqid(), 'pageBlockId' => $id] );
    }

    /**
     * 加载示例图片
     * @param $id
     * @return false|mixed
     */
    public function actionLoadIcon( $id )
    {
        $block = PageBlock::findOne( $id );
        $class = $block->namespace . '\Icon';
        return call_user_func( [$class, 'widget'] );
    }
}
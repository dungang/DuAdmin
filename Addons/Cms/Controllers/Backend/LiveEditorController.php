<?php


namespace Addons\Cms\Controllers\Backend;

use Addons\Cms\Models\Page;
use Addons\Cms\Models\PageBlock;
use Addons\Cms\Models\PagePost;
use Addons\Cms\PageBlock\ElementSection\PlaceHolder;
use Addons\Cms\PageBlock\LayoutSection\Icon;

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
    public function actionIndex( $pageId,$language = 'zh-CN' )
    {
        $fields = ['pageId'=>$pageId,'language'=>$language];
        $pagePost = PagePost::findOne($fields);
        if(empty($pagePost)) {
            $pagePost = new PagePost($fields);
        }
        return $this->render( 'index', ['model' => $pagePost] );
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
        return call_user_func( [$class, 'widget'] );
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
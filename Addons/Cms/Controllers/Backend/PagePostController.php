<?php

namespace Addons\Cms\Controllers\Backend;

use Addons\Cms\Models\Page;
use Addons\Cms\Models\PagePost;
use Addons\Cms\Models\PagePostSearch;
use DuAdmin\Core\BackendController;
use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PagePost 模型的控制器
 * PagePostController 实现了常规的增删查改等行为
 */
class PagePostController extends BackendController
{

    /**
     * 列出所有的 PagePost 模型.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new PagePostSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
        return $this->render( 'index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider
        ] );

    }

    /**
     * 显示单个的 PagePost 模型数据.
     *
     * @param integer $pageId
     * @param string $language
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView( $pageId, $language )
    {
        $model = $this->findModel($pageId,$language);
        return $this->redirect( AppHelper::createFrontendUrl($model->page->slug));

    }

    /**
     * 创建一个新的 PagePost 模型.
     * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
     *
     * @param $pageId
     * @param string $language
     * @return mixed
     */
    public function actionCreate( $pageId, $language = "zh-CN" )
    {
        return $this->redirect( ['/cms/live-editor', 'pageId' => $pageId, 'language' => $language] );
    }

    /**
     * 更新一条已经存在的 PagePost 模型.
     * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
     *
     * @param integer $pageId
     * @param string $language
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionUpdate( $pageId, $language )
    {
        return $this->redirect( ['/cms/live-editor', 'pageId' => $pageId, 'language' => $language] );

    }

    /**
     * 删除一条存在的 PagePost 模型.
     * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
     *
     * @param integer $pageId
     * @param string $language
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionDelete( $pageId, $language )
    {

        if ( is_array( $pageId, $language ) ) {
            $modelList = PagePost::findAll( [
                'pageId'   => $pageId,
                'language' => $language
            ] );
            if ( $modelList ) {
                foreach ( $modelList as $model ) {
                    $model->delete();
                }
            }
        } else {
            $this->findModel( $pageId, $language )->delete();
        }
        return $this->redirect( [
            'index'
        ] );

    }

    /**
     * 根据模型的主键Id查询 PagePost 模型.
     * 如果模型没有找到, 404 HTTP 异常将会抛出.
     *
     * @param integer $pageId
     * @param string $language
     * @return PagePost the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel( $pageId, $language )
    {

        if ( ($model = PagePost::findOne( [
                'pageId'   => $pageId,
                'language' => $language
            ] )) !== null ) {
            return $model;
        }
        throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );

    }

    protected function checkLiveEditMode( $pageId, $language )
    {
        if(Yii::$app->request->isGet) {
            $page = Page::findOne( $pageId );
            if ( $page->isLive ) {
                return $this->redirect( ['/cms/live-editor', 'pageId' => $pageId, 'language' => $language] );
            }
        }
        return false;
    }
}

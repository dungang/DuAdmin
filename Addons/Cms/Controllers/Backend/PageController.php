<?php

namespace Addons\Cms\Controllers\Backend;

use Addons\Cms\Models\Page;
use Addons\Cms\Models\PagePost;
use Addons\Cms\Models\PageSearch;
use DuAdmin\Core\BackendController;
use DuAdmin\Core\BizException;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Page 模型的控制器
 * PageController 实现了常规的增删查改等行为
 */
class PageController extends BackendController {

    /**
     * 列出所有的 Page 模型.
     *
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
        $dataProvider->query->with( 'languages' );
        return $this->render( 'index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider
            ] );
    }

    /**
     * 显示单个的 Page 模型数据.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView( $id ) {

        return $this->render( 'view', [
                'model' => $this->findModel( $id )
            ] );
    }

    /**
     * 创建一个新的 Page 模型.
     * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
     *
     * @return mixed
     */
    public function actionCreate() {

        $model = new Page();
        // ajax表单验证
        if ( ($error = $this->ajaxValidation( $model )) !== false ) {
            return $error;
        }
        if ( $model->load( Yii::$app->request->post() ) ) {
            return Yii::$app->db->transaction( function ( $db ) use ( $model ) {
                    if ( $model->save() ) {
                        $postData = new PagePost( [
                            'pageId'   => $model->id,
                            'title'    => $model->title,
                            'language' => Yii::$app->language,
                            ] );
                        if ( $postData->save( false ) ) {

                            return $this->redirectSuccess( [
                                    'view',
                                    'id' => $model->id
                                    ], "添加成功" );
                        } else {
                            throw new BizException( "添加失败" );
                        }
                    }
                } );
        }
        return $this->render( 'create', [
                'model' => $model
            ] );
    }

    /**
     * 更新一条已经存在的 Page 模型.
     * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionUpdate( $id ) {

        $model = $this->findModel( $id );
        // ajax表单验证
        if ( ($error = $this->ajaxValidation( $model )) !== false ) {
            return $error;
        }
        if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
            return $this->redirectSuccess( [
                    'view',
                    'id' => $model->id
                    ], "修改成功" );
        }
        return $this->render( 'update', [
                'model' => $model
            ] );
    }

    /**
     * 删除一条存在的 Page 模型.
     * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionDelete( $id ) {

        if ( is_array( $id ) ) {
            $modelList = Page::findAll( [
                    'id' => $id
                ] );
            if ( $modelList ) {
                foreach ( $modelList as $model ) {

                    $model->delete();
                }
            }
        } else {
            $this->findModel( $id )->delete();
        }
        return $this->redirect( [
                'index'
            ] );
    }

    /**
     * 根据模型的主键Id查询 Page 模型.
     * 如果模型没有找到, 404 HTTP 异常将会抛出.
     *
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel( $id ) {

        if ( ($model = Page::findOne( [
                'id' => $id
            ] )) !== null ) {
            return $model;
        }
        throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );
    }

}

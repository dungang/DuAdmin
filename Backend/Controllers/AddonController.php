<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use DuAdmin\Core\BizException;
use yii\data\ArrayDataProvider;
use DuAdmin\Helpers\LoaderHelper;

/**
 * 插件管理
 * Class AddonController
 * @package Backend\Controllers
 */
class AddonController extends BackendController
{
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider( [
            'models' => LoaderHelper::dynamicParseAddons()
        ] );
        return $this->render( 'index', ['dataProvider' => $dataProvider] );
    }

    /**
     * 安装插件
     * @param $name
     * @return \yii\web\Response
     * @throws BizException
     */
    public function actionInstall( $name )
    {
        $dirPath = \Yii::$app->basePath . '/Addons/' . $name;
        if ( is_dir( $dirPath ) ) {
            touch( $dirPath . '/installed.lock' );
            return $this->redirectSuccess( ['index'], "安装成功" );
        }
        throw new BizException( "插件不存在" );
    }

    /**
     * 卸载插件
     * @param $name
     * @return \yii\web\Response
     * @throws BizException
     */
    public function actionUninstall( $name )
    {
        $dirPath = \Yii::$app->basePath . '/Addons/' . $name;
        if ( is_dir( $dirPath ) ) {
            @unlink( $dirPath . '/installed.lock' );
            return $this->redirectSuccess( ['index'], "卸载成功" );
        }
        throw new BizException( "插件不存在" );
    }
}


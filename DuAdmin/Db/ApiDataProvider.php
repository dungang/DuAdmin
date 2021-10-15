<?php

namespace DuAdmin\Db;

use yii\data\BaseDataProvider;

/**
 * Class ApiDataProvider
 * @package Addons\Weixin\Components
 */
class ApiDataProvider extends BaseDataProvider
{

    public $modelKey = 'id';

    /**
     * @var callable
     */
    public $dataSource;

    public int $modelTotal = 0;

    protected function prepareModels(): array
    {
        $pageSize = 0;
        $pageNo = 1;
        if ( ($pagination = $this->getPagination()) !== false ) {
            $pageSize = $pagination->getPageSize();
            $pageNo = \Yii::$app->request->get( $pagination->pageParam, 1 );
        }

        $data = call_user_func( $this->dataSource, $pageNo,$pageSize );

        if ( isset( $data[ 'count' ] ) ) {
            $this->modelTotal = $data[ 'count' ];
        } else {
            $this->modelTotal = 0;
        }
        if($pagination) {
            $pagination->totalCount = $this->modelTotal;
        }
        if ( (isset( $data[ 'data' ] )) ) {
            return $data[ 'data' ];
        } else {
            return [];
        }

    }

    protected function prepareKeys( $models )
    {
        if ( $this->modelKey !== null ) {
            $keys = [];
            foreach ( $models as $model ) {
                if ( is_string( $this->modelKey ) ) {
                    $keys[] = $model[ $this->modelKey ];
                } else {
                    $keys[] = call_user_func( $this->modelKey, $model );
                }
            }
            return $keys;
        }

        return array_keys( $models );
    }

    protected function prepareTotalCount()
    {
        return $this->modelTotal;
    }

}
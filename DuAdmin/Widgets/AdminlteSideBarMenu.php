<?php

namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\helpers\Html;
use DuAdmin\Core\Authable;
use yii\helpers\Url;

/**
 * 指支持2层菜单
 *
 * @author dungang
 *
 */
class AdminlteSideBarMenu extends Widget
{

    public $headerLabel = 'Header';

    public $enableHeader = true;

    public $idKey = 'id';

    public $pidKey = 'pid';

    public $urlKey = 'url';

    public $nameKey = 'label';

    public $activeKey = '__is_active';

    public $items;

    public function run()
    {
        $this->normalizeItems();

        // 权限过滤
        /* @var Authable $user */
        $user = Yii::$app->user->identity;
        if ( !$user->isSuperAdmin() ) {
            $this->items = array_filter( $this->items, function ( $item ) use ($user) {
                //echo var_dump( $item);die;
                if ( $item[ 'requireAuth' ] ) {
                    if ( isset( $item[ 'route' ] ) && $item[ 'route' ] != 'default/index' ) {
                        return Yii::$app->authManager->checkAccessWithoutRule( $user->id, trim( $item[ 'route' ], '/' ) );
                    }
                }
                return true;
            } );
        }
        $this->items = AppHelper::listToTree( $this->items, $this->idKey, $this->pidKey );
        $html = $this->enableHeader ? Html::tag( 'li', $this->headerLabel, [
            'class' => 'header'
        ] ) : '';
        // url 为空 或者 是 '#' 的菜单没有子菜单 不显示
        foreach ( $this->items as $item ) {
            if ( isset( $item[ 'children' ] ) && is_array( $item[ 'children' ] ) ) {
                $html .= $this->renderTreeItem( $item );
            } else if ( !(empty( $item[ 'url' ] ) || $item[ 'url' ] == '#') ) {
                $html .= $this->renderItem( $item );
            }
        }
        return Html::tag( 'div', $html, [
            'class'       => 'sidebar-menu',
            'data-widget' => 'tree'
        ] );
    }

    /**
     *
     * @throws \yii\base\InvalidConfigException
     */
    protected function normalizeItems()
    {
        if ( empty( $this->items ) ) {
            return;
        }
        $controllerUnionId = \Yii::$app->controller->uniqueId;
        $controllerRouteParts = explode( '/', trim( $controllerUnionId, '/' ) );
        $params = [];
        parse_str(\Yii::$app->request->queryString , $params );
        $counters = [];

        // 算分
        foreach ( $this->items as $i => &$item ) {
            $item[ $this->activeKey ] = false;
            $item[ 'target' ] = '_self';
            if ( $item[ 'isOuter' ] ) {
                $item[ 'target' ] = '_blank';
                continue;
            } else {
                if ( $url = $item[ $this->urlKey ] ) {
                    $urlInfo = parse_url( $url );
                    if ( isset( $urlInfo[ 'path' ] ) ) {
                        // 路径就是route
                        $route = $urlInfo[ 'path' ];
                        $routeParts = explode( '/', trim( $route, '/' ) );
                        $counters[ $i ] = 1;
                        // 检查路由前缀加分
                        //$counters[ $i ] += \stripos( $route, $controllerUnionId ) == 0 ? 1 : 0;
                        $counters[ $i ] += count( array_intersect_assoc( $routeParts, $controllerRouteParts ) );
                        $queryParams = [
                            $urlInfo[ 'path' ]
                        ];
                        if ( isset( $urlInfo[ 'query' ] ) ) {

                            \parse_str( $urlInfo[ 'query' ] , $queryParams );

                            $counters[ $i ] += count( array_intersect_assoc( $queryParams, $params ) );
                            $queryKeys = array_keys( $queryParams );
                            $queryParams = array_combine( $queryKeys, array_values( $queryParams ) );
                            array_unshift( $queryParams, $urlInfo[ 'path' ] );
                        }
                        $queryParams[ 0 ] = '/' . $queryParams[ 0 ];
                        $item[ $this->urlKey ] = Url::to( $queryParams );
                        
                        $item['route'] = $route;
                        unset($queryParams[0]);
                        $item['params'] = $queryParams;
                    } else {
                        continue;
                    }
                }
            }
        }

        // 找最高分
        $max = 0;
        $idx = 0;
        foreach ( $counters as $i => $count ) {
            if ( $count > $max ) {
                $max = $count;
                $idx = $i;
            }
        }
        $activeItem = $this->items[ $idx ];
        $this->items[ $idx ][ $this->activeKey ] = true;

        // 找最高分的一层上节点
        foreach ( $this->items as &$item ) {
            if ( $item[ $this->idKey ] == $activeItem[ 'pid' ] ) {
                $item[ $this->activeKey ] = true;
            }
        }
    }

    protected function renderLink( $item )
    {
        $icon = empty( $item[ 'icon' ] ) ? '' : '<i class="' . $item[ 'icon' ] . '"></i> ';
        return Html::a( $icon . '<span>' . $item[ $this->nameKey ] . '</span>', $item[ $this->urlKey ], [
            'target' => $item[ 'target' ]
        ] );
    }

    protected function renderItem( $item )
    {
        $active = $item[ $this->activeKey ] ? [
            'class' => 'active'
        ] : [];
        return Html::tag( 'li', $this->renderLink( $item ), $active );
    }

    protected function renderTreeItem( $item )
    {
        $active = $item[ $this->activeKey ] ? 'active' : '';
        $html = '';
        foreach ( $item[ 'children' ] as $child ) {
            $html .= $this->renderItem( $child );
        }
        $content = $this->renderLink( $item ) . Html::tag( 'ul', $html, [
                'class' => 'treeview-menu'
            ] );
        return Html::tag( 'li', $content, [
            'class' => 'treeview ' . $active
        ] );
    }
}

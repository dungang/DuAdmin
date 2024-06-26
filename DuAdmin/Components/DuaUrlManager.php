<?php

namespace DuAdmin\Components;

use Yii;
use yii\web\Request;
use yii\web\UrlManager;

class DuaUrlManager extends UrlManager {

  /**
   * 公共参数
   * 保证每一个url都包含的参数
   *
   * @var array
   */
  public $common_params = [ ];

  /**
   *
   * @var string the cache key for cached rules
   * @since 2.0.8
   */
  protected $cacheKey = __CLASS__;

  /**
   *
   * {@inheritdoc}
   * @see \yii\web\UrlManager::createUrl()
   */
  public function createUrl( $params ) {

    if ( $this->common_params && \is_array( $params ) ) {
      $params = array_merge( $this->common_params, $params );
    }
    return parent::createUrl( $params );

  }

  /**
   * 此处相对原版做了处理的顺序调整
   * Parses the user request.
   *
   * @param Request $request
   *          the request component
   * @return array|bool the route and the associated parameters. The latter is always empty
   *         if [[enablePrettyUrl]] is `false`. `false` is returned if the current request cannot be successfully parsed.
   */
  public function parseRequest( $request ) {

    if ( $this->enablePrettyUrl ) {
      /* @var $rule \yii\web\UrlRule */
      foreach ( $this->rules as $rule ) {
        $result = $rule->parseRequest( $this, $request );
        if ( YII_DEBUG ) {
          Yii::debug( [
              'rule' => method_exists( $rule, '__toString' ) ? $rule->__toString() : get_class( $rule ),
              'match' => $result !== false,
              'parent' => null
          ], __METHOD__ );
        }
        if ( $result !== false ) {
          return $result;
        }
      }
      if ( $route = $request->getQueryParam( $this->routeParam, '' ) ) {
        Yii::debug( 'Pretty URL not enabled. Using default URL parsing logic.', __METHOD__ );
        if ( is_array( $route ) ) {
          $route = '';
        }
        return [
            ( string ) $route,
            [ ]
        ];
      }
      if ( $this->enableStrictParsing ) {
        return false;
      }
      Yii::debug( 'No matching URL rules. Using default URL parsing logic.', __METHOD__ );
      $pathInfo = $request->getPathInfo();
      $suffix = ( string ) $this->suffix;
      $normalized = false;
      if ( $this->normalizer !== false ) {
        $pathInfo = $this->normalizer->normalizePathInfo( $pathInfo, $suffix, $normalized );
      }
      if ( $suffix !== '' && $pathInfo !== '' ) {
        $n = strlen( $this->suffix );
        if ( substr_compare( $pathInfo, $this->suffix, - $n, $n ) === 0 ) {
          $pathInfo = substr( $pathInfo, 0, - $n );
          if ( $pathInfo === '' ) {
            // suffix alone is not allowed
            return false;
          }
        } else {
          // suffix doesn't match
          return false;
        }
      }
      if ( $normalized ) {
        // pathInfo was changed by normalizer - we need also normalize route
        return $this->normalizer->normalizeRoute( [
            ( string ) $pathInfo,
            [ ]
        ] );
      }
      return [
          ( string ) $pathInfo,
          [ ]
      ];
    }
    Yii::debug( 'Pretty URL not enabled. Using default URL parsing logic.', __METHOD__ );
    $route = $request->getQueryParam( $this->routeParam, '' );
    if ( is_array( $route ) ) {
      $route = '';
    }
    return [
        ( string ) $route,
        [ ]
    ];

  }
}

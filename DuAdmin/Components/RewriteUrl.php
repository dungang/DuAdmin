<?php

namespace DuAdmin\Components;

use Yii;
use yii\web\UrlManager;
use yii\web\UrlNormalizer;
use yii\base\InvalidConfigException;
use DuAdmin\Models\Rewrite;
use yii\helpers\ArrayHelper;
use yii\web\Request;

/**
 *
 * @author dungang
 */
class RewriteUrl extends UrlManager
{
    /**
     * 公共参数
     * 保证每一个url都包含的参数
     * 
     * @var array
     */
    public $common_params = [];

    public $from_db = false;


    /**
     * Initializes UrlManager.
     */
    public function init()
    {
        if ($this->normalizer !== false) {
            $this->normalizer = Yii::createObject($this->normalizer);
            if (!$this->normalizer instanceof UrlNormalizer) {
                throw new InvalidConfigException('`' . get_class($this) . '::normalizer` should be an instance of `' . UrlNormalizer::className() . '` or its DI compatible configuration.');
            }
        }

        if (!$this->enablePrettyUrl) {
            return;
        }
        if (is_string($this->cache)) {
            $this->cache = Yii::$app->get($this->cache, false);
        }
        if ($this->from_db) {
            $this->rules = ArrayHelper::merge($this->rules, $this->getRulesFromDb());
        }
        if (empty($this->rules)) {
            return;
        }
        $this->rules = $this->buildRules($this->rules);
    }
    
    /**
     *
     * {@inheritdoc}
     * @see \yii\web\UrlManager::createUrl()
     */
    public function createUrl($params)
    {
        if ($this->common_params && \is_array($params)) {
            $params = array_merge($this->common_params, $params);
        }
        $anchor = isset($params['#']) ? '#' . $params['#'] : '';
        unset($params['#'], $params[$this->routeParam]);
        
        $route = trim($params[0], '/');
        unset($params[0]);
        
        $baseUrl = $this->showScriptName || ! $this->enablePrettyUrl ? $this->getScriptUrl() : $this->getBaseUrl();
        
        if ($this->enablePrettyUrl) {
            $cacheKey = $route . '?';
            foreach ($params as $key => $value) {
                if ($value !== null) {
                    $cacheKey .= $key . '&';
                }
            }
            
            $url = $this->getUrlFromCache($cacheKey, $route, $params);
            if ($url === false) {
                /* @var $rule \yii\rest\UrlRule */
                foreach ($this->rules as $rule) {
                    if (in_array($rule, $this->_ruleCache[$cacheKey], true)) {
                        // avoid redundant calls of `UrlRule::createUrl()` for rules checked in `getUrlFromCache()`
                        // @see https://github.com/yiisoft/yii2/issues/14094
                        continue;
                    }
                    $url = $rule->createUrl($this, $route, $params);
                    if ($this->canBeCached($rule)) {
                        $this->setRuleToCache($cacheKey, $rule);
                    }
                    if ($url !== false) {
                        break;
                    }
                }
            }
            
            if ($url !== false) {
                if (strpos($url, '://') !== false) {
                    if ($baseUrl !== '' && ($pos = strpos($url, '/', 8)) !== false) {
                        return substr($url, 0, $pos) . $baseUrl . substr($url, $pos) . $anchor;
                    }
                    
                    return $url . $baseUrl . $anchor;
                } elseif (strncmp($url, '//', 2) === 0) {
                    if ($baseUrl !== '' && ($pos = strpos($url, '/', 2)) !== false) {
                        return substr($url, 0, $pos) . $baseUrl . substr($url, $pos) . $anchor;
                    }
                    
                    return $url . $baseUrl . $anchor;
                }
                
                $url = ltrim($url, '/');
                return "$baseUrl/{$url}{$anchor}";
            }
            
            if ($this->suffix !== null) {
                $route .= $this->suffix;
            }
            if (! empty($params) && ($query = http_build_query($params)) !== '') {
                $route .= '?' . $query;
            }
            
            $route = ltrim($route, '/');
            return "$baseUrl/{$route}{$anchor}";
        }
        
        $url = "$baseUrl?{$this->routeParam}=" . $route;
        if (! empty($params) && ($query = http_build_query($params)) !== '') {
            $url .= '&' . $query;
        }
        
        return $url . $anchor;
    }

    /**
     * 从数据库读取重写规则
     *
     * @return array|null
     */
    protected function getRulesFromDb()
    {
        if (\Yii::$app->db) {
            return Rewrite::allIdToName('express', 'route', null, 'weight DESC');
        } else {
            return null;
        }
    }

    /**
     * 此处相对原版做了处理的顺序调整
     * Parses the user request.
     *
     * @param Request $request
     *            the request component
     * @return array|bool the route and the associated parameters. The latter is always empty
     *         if [[enablePrettyUrl]] is `false`. `false` is returned if the current request cannot be successfully parsed.
     */
    public function parseRequest($request)
    {
        if ($this->enablePrettyUrl) {
            /* @var $rule \yii\web\UrlRule */
            foreach ($this->rules as $rule) {
                $result = $rule->parseRequest($this, $request);
                if (YII_DEBUG) {
                    Yii::debug([
                        'rule' => method_exists($rule, '__toString') ? $rule->__toString() : get_class($rule),
                        'match' => $result !== false,
                        'parent' => null
                    ], __METHOD__);
                }
                if ($result !== false) {
                    return $result;
                }
            }

            if ($route = $request->getQueryParam($this->routeParam, '')) {

                Yii::debug('Pretty URL not enabled. Using default URL parsing logic.', __METHOD__);
                if (is_array($route)) {
                    $route = '';
                }

                return [
                    (string) $route,
                    []
                ];
            }


            if ($this->enableStrictParsing) {
                return false;
            }

            Yii::debug('No matching URL rules. Using default URL parsing logic.', __METHOD__);

            $pathInfo = $request->getPathInfo();
            $suffix = (string) $this->suffix;
            $normalized = false;
            if ($this->normalizer !== false) {
                $pathInfo = $this->normalizer->normalizePathInfo($pathInfo, $suffix, $normalized);
            }
            if ($suffix !== '' && $pathInfo !== '') {
                $n = strlen($this->suffix);
                if (substr_compare($pathInfo, $this->suffix, -$n, $n) === 0) {
                    $pathInfo = substr($pathInfo, 0, -$n);
                    if ($pathInfo === '') {
                        // suffix alone is not allowed
                        return false;
                    }
                } else {
                    // suffix doesn't match
                    return false;
                }
            }

            if ($normalized) {
                // pathInfo was changed by normalizer - we need also normalize route
                return $this->normalizer->normalizeRoute([
                    $pathInfo,
                    []
                ]);
            }

            return [
                $pathInfo,
                []
            ];
        }
    }
}

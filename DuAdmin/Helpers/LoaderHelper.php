<?php

namespace DuAdmin\Helpers;

use Composer\Autoload\ClassLoader;
use RuntimeException;
use yii\helpers\BaseFileHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

class LoaderHelper
{

    /**
     * 加载器
     *
     * @var ClassLoader
     */
    public static $composerLoader = null;

    public static function getComposerLoader()
    {
        foreach (spl_autoload_functions() as $loader) {
            if ($loader[0] instanceof ClassLoader) {
                static::$composerLoader = $loader[0];
            }
        }
        if (static::$composerLoader == null) {
            throw new RuntimeException('Composer Class Loader Instance Not Found!');
        }
        return static::$composerLoader;
    }

    public static function addFiles(array $files)
    {
        foreach ($files as $fileIdentifier => $file) {
            if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
                require $file;
                $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;
            }
        }
    }

    /**
     * 命名空间映射
     *
     * @param string $namespace
     * @param string $path
     */
    public static function addNamespace(string $namespace, string $path = '')
    {
        static::getComposerLoader()->set($namespace, $path);
    }

    /**
     * 添加多个prs4规则映射
     *
     * @param array $prs4
     */
    public static function addMoreNamespace(array $namespaces)
    {
        foreach ($namespaces as $namespace => $path) {
            static::getComposerLoader()->set($namespace, $path);
        }
    }

    public static function addPsr4(string $prefix, string $path = '')
    {
        static::getComposerLoader()->setPsr4($prefix, $path);
    }

    /**
     * 添加多个prs4规则映射
     *
     * @param array $prs4
     */
    public static function addMorePsr4(array $prs4)
    {
        foreach ($prs4 as $prefix => $path) {
            if (is_string($path)) {
                $path = \Yii::getAlias($path);
            }
            static::getComposerLoader()->setPsr4($prefix, $path);
        }
    }

    /**
     * 添加类映射数组
     *
     * @param array $classMap
     */
    public static function addClassMap(array $classMap)
    {
        static::getComposerLoader()->addClassMap($classMap);
    }

    /**
     * 注册插件的库文件到加载器中
     *
     * @param array $addon
     */
    public static function loadAddonLibs(array $addon)
    {
        if (isset($addon['classMap']) && $addon['classMap']) {
            static::addClassMap($addon['classMap']);
        }
        if (isset($addon['namespaces']) && $addon['namespaces']) {
            static::addMoreNamespace($addon['namespaces']);
        }
        if (isset($addon['psr4']) && $addon['psr4']) {
            static::addMorePsr4($addon['psr4']);
        }
        if (isset($addon['files']) && $addon['files']) {
            static::addFiles($addon['files']);
        }
    }

    private static $installedAddonsData = null;

    public static function loadInstalledAddonsConfig()
    {
        $installedAddonsFile = \Yii::$app->basePath . '/Config/installed-addons.php';
        $innerAddonsFile = \Yii::$app->basePath . '/Config/inner-addons.php';
        $installedAddons = require($innerAddonsFile);
        if (!file_exists($installedAddonsFile)) {
            file_put_contents($installedAddonsFile, "<?php\nreturn " . VarDumper::export($installedAddons) . ";\n");
        } else {
            $installedAddons = require($installedAddonsFile);
        }
        return $installedAddons;
    }

    public static function saveInstalledAddonsConfig($installedAddons)
    {
        $installedAddonsFile = \Yii::$app->basePath . '/Config/installed-addons.php';
        file_put_contents($installedAddonsFile, "<?php\nreturn " . VarDumper::export($installedAddons) . ";\n");
        static::dynamicParseAddons(true);
    }

    /**
     * 动态解析插件配置文件
     *
     * @param boolean $fresh
     * @return mixed|mixed[]
     */
    public static function dynamicParseAddons($fresh = false)
    {
        if ($fresh === false && !empty(static::$installedAddonsData)) {
            return static::$installedAddonsData;
        }
        $installedAddons = static::loadInstalledAddonsConfig();
        $all_addons_json = \Yii::$app->basePath . '/runtime/Addons.json';
        $addons = [];
        if ($fresh === false && YII_ENV_PROD && file_exists($all_addons_json)) {
            static::$installedAddonsData = json_decode(file_get_contents($all_addons_json), true);
            return static::$installedAddonsData;
        }
        $dirs = BaseFileHelper::findDirectories(\Yii::$app->basePath . '/Addons', [
            'recursive' => false
        ]);
        foreach ($dirs as $name) {
            $addonName = basename($name);
            $addonDir = \Yii::$app->basePath . '/Addons/' . $addonName;
            $addonVendorComposerDir = $addonDir . '/vendor/composer';
            $jsonFile = $addonDir . '/addon.json';
            if (file_exists($jsonFile)) {
                try {
                    $addon = json_decode(file_get_contents($jsonFile), true);
                    $addon['id'] = Inflector::camel2id($addonName);
                    $addon['addon'] = $addonName;
                    $addon['hasSetting'] = isset($addon['hasSetting']) ?: false;
                    $addon['mainClass'] = 'Addons\\' . $addonName . '\\Addon';
                    if (file_exists($addonVendorComposerDir . '/autoload_classmap.php')) {
                        $addon['classMap'] = require $addonVendorComposerDir . '/autoload_classmap.php';
                    }
                    if (file_exists($addonVendorComposerDir . '/autoload_namespaces.php')) {
                        $addon['namespaces'] = require $addonVendorComposerDir . '/autoload_namespaces.php';
                    }
                    if (file_exists($addonVendorComposerDir . '/autoload_psr4.php')) {
                        $addon['psr4'] = require $addonVendorComposerDir . '/autoload_psr4.php';
                    }
                    if (file_exists($addonVendorComposerDir . '/autoload_files.php')) {
                        $addon['files'] = require $addonVendorComposerDir . '/autoload_files.php';
                    }
                    //if ( file_exists( $addonDir . '/installed.lock' ) ) {
                    if (in_array($addonName, $installedAddons)) {
                        $addon['active'] = true;
                    } else {
                        $addon['active'] = false;
                    }
                    $addons[] = $addon;
                } catch (\Exception $e) {
                    \Yii::error('Load Addon ' . $addonName . ' error');
                }
            }
        }
        if (YII_ENV_PROD) {
            file_put_contents($all_addons_json, json_encode($addons, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE));
        } else {
            file_put_contents($all_addons_json, json_encode($addons, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE));
        }
        static::$installedAddonsData = $addons;
        return static::$installedAddonsData;
    }
}

<?php

namespace app\mmadmin\helpers;

use Composer\Autoload\ClassLoader;
use RuntimeException;

class LoaderHelper
{

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

    public static function addNamespace($namespace, $path = '')
    {
        static::getComposerLoader()->set($namespace, [$path]);
    }


    public static function addPsr4($namespace, $path = '')
    {
        static::getComposerLoader()->setPsr4($namespace, [$path]);
    }


    public static function addClassMap($classMap)
    {
        static::getComposerLoader()->addClassMap($classMap);
    }
}

<?php

namespace app\mmadmin\helpers;

class LoaderHelper
{
    public static function addNamespace($namespace,$path='') {
        global $classLoader;
        $classLoader->set($namespace,[$path]);
    }


    public static function addPsr4($namespace,$path='') {
        global $classLoader;
        $classLoader->setPsr4($namespace,[$path]);
    }

    
    public static function addClassMap($classMap) {
        global $classLoader;
        $classLoader->addClassMap($classMap);
    }
}
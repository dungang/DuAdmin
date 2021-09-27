<?php
namespace DuAdmin\Scripts;

class ComposerInstaller
{
    public static function createPublicAssets($event){
        $baseDir =  dirname(dirname(__DIR__));
        if(!is_dir($baseDir . '/Public/assets')) {
            mkdir($baseDir . '/Public/assets',0777,true); 
        }
    }
}
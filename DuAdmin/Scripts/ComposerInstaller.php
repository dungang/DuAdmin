<?php
namespace DuAdmin\Scripts;

class ComposerInstaller
{
    public static function createPublicAssets($event){
        $baseDir =  dirname(dirname(__DIR__));
        if(!is_dir($baseDir . '/public/assets')) {
            mkdir($baseDir . '/public/assets',0777,true); 
        }
    }
}
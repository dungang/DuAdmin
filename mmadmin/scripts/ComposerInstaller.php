<?php
namespace app\mmadmin\scripts;

class ComposerInstaller
{
    public static function createPublicAssets(){
        $baseDir =  basename(basename(__DIR__));
        if(!is_dir($baseDir . '/public/assets')) {
           mkdir($baseDir,0775,true); 
        }
    }
}


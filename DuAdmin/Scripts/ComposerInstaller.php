<?php

namespace DuAdmin\Scripts;

/**
 * 运行composer install 之后执行的脚本
 */
class ComposerInstaller
{
    /**
     * 创建入口的资源文件目录
     */
    public static function createPublicAssets($event)
    {
        $baseDir =  dirname(dirname(__DIR__));
        if (!is_dir($baseDir . '/Public/assets')) {
            mkdir($baseDir . '/Public/assets', 0777, true);
        }
    }

    /**
     * 创建代码生成器配置文件，配置处于开发模式的插件
     */
    public static function createGeneratorConfig($event)
    {
        $baseDir =  dirname(dirname(__DIR__));
        if (!is_file($baseDir . '/Public/generator.php')) {
            file_put_contents($baseDir . '/Public/generator.php', "<?php\nreturn [];\n");
        }
    }
}

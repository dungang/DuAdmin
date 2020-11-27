<?php
namespace app\console;

use yii\console\Controller;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\helpers\Console;
use yii\helpers\ArrayHelper;

/**
 *
 * @author dungang
 *        
 */
class AddonController extends Controller
{

    /**
     * 输出命令的所有命令
     */
    public function actionIndex()
    {
        $this->stdout("插件命令行说明：" . PHP_EOL);
        $this->stdout(PHP_EOL);
        $this->stdout("\t创建插件 addon/create AddonName 插件标题" . PHP_EOL);
        $this->stdout("\t安装插件 addon/install AddonName " . PHP_EOL);
        $this->stdout("\t卸载插件 addon/uninstall AddonName " . PHP_EOL);
        $this->stdout(PHP_EOL);
    }

    /**
     * 安装插件
     *
     * @param string $addonName
     *            插件名称
     */
    public function actionInstall($addonName)
    {}

    /**
     * 卸载插件
     *
     * @param string $addonName
     *            插件名称
     */
    public function actionUninstall($addonName)
    {}

    /**
     * 清除插件安装配置
     */
    public function actionClear($addonName)
    {}

    /**
     * 刷新配置文件
     */
    public function actionJson($addonName, $addonTitle, $type = "app")
    {
        $addonDir = \Yii::getAlias('@Addons/' . $addonName);
        $addonJsonFile = $addonDir . DIRECTORY_SEPARATOR . 'addon.json';
        $oldJson = [];
        $writable = true;
        if (file_exists($addonJsonFile)) {
            $this->stdout("文件已经存在\n" . $addonJsonFile . "\n", Console::FG_YELLOW);
            $writable = $this->confirm("是否覆盖？原先的数据会丢失");
            try {
                $oldJson = json_decode(file_get_contents($addonJsonFile), true);
            } catch (\Exception $e) {
                $this->stdout($addonJsonFile . "不是json文件\n", Console::FG_YELLOW);
                $writable = $this->confirm("是否覆盖？原先的数据会丢失");
            }
        }
        if ($writable) {
            $addon = [
                'name' => $addonTitle,
                'type' => $type,
                'version' => '1.0.0',
                'intro' => Inflector::camel2words($addonName) . ' ' . $addonTitle,
                'hasApi' => false,
                'hasFrontend' => false,
                'hasBackend' => true,
                'hasConsole' => false,
                'hooksMap' =>[]
            ];
            $data = ArrayHelper::merge($addon, $oldJson);
            file_put_contents($addonJsonFile, json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            $this->stdout("创建成功\n" . $addonJsonFile . "\n\n", Console::FG_GREEN);
        }
    }

    /**
     * 创建插件
     *
     * @param string $addonName
     *            插件名词
     * @param string $addonTitle
     *            插件标题
     */
    public function actionCreate($addonName, $addonTitle)
    {
        $addonDir = \Yii::getAlias('@Addons/' . $addonName);
        $dirs = [
            $addonDir
        ];
        $dirs[] = $addonDir . '/Controllers/Backend';
        $dirs[] = $addonDir . '/Controllers/Frontend';
        $dirs[] = $addonDir . '/Controllers/Api';
        $dirs[] = $addonDir . '/Models';
        $dirs[] = $addonDir . '/Hooks';
        $dirs[] = $addonDir . '/Widgets';
        $dirs[] = $addonDir . '/resource';
        $dirs[] = $addonDir . '/resource/messages';
        $dirs[] = $addonDir . '/resource/views';
        $dirs[] = $addonDir . '/resource/views/backend';
        $dirs[] = $addonDir . '/resource/views/frontend';
        $create = false;
        try {
            if (file_exists($addonDir)) {
                $create = $this->confirm('插件已经存在，是否覆盖?');
            } else {
                $create = true;
            }
            if ($create) {
                $this->createAddon($addonName, $addonTitle, $addonDir, $dirs);
                $this->stdout("插件创建成功" . PHP_EOL);
            }
        } catch (\Exception $e) {
            $this->stderr($e->getMessage() . PHP_EOL);
            $this->actionIndex();
        }
        $this->stdout(PHP_EOL);
    }

    protected function createAddon($addonName, $addonTitle, $addonDir, $dirs)
    {
        foreach ($dirs as $dir) {
            FileHelper::createDirectory($dir);
        }
        $addonStub = __DIR__ . '/stubs/Addon.stub';
        $addonClassFile = $addonDir . '/Addon.php';
        if (file_exists($addonStub)) {
            $stub_content = file_get_contents($addonStub);
            $content = str_replace([
                '{{ addonName }}',
                '{{ addonTitle }}',
                '{{ addonId }}'
            ], [
                $addonName,
                $addonTitle,
                Inflector::camel2id($addonName)
            ], $stub_content);
            file_put_contents($addonClassFile, $content);
        }
    }
}


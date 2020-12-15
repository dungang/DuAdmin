<?php
namespace Console;

use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\helpers\Console;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 *
 * @author dungang
 *        
 */
class AddonController extends BaseController
{

    /**
     * 输出命令的所有命令
     */
    public function actionIndex()
    {
        $this->stdout("插件命令行说明：" . PHP_EOL);
        $this->stdout(PHP_EOL);
        $this->stdout("\t创建插件 addon/create" . PHP_EOL);
        $this->stdout("\t安装插件 addon/install " . PHP_EOL);
        $this->stdout("\t卸载插件 addon/uninstall " . PHP_EOL);
        $this->stdout(PHP_EOL);
    }

    /**
     * 安装插件
     */
    public function actionInstall()
    {
        Console::output($this->selectOneAddonName());
    }

    /**
     * 卸载插件
     */
    public function actionUninstall()
    {
        Console::output($this->selectOneAddonName());
    }

    /**
     * 清除插件安装配置
     */
    public function actionClear()
    {
        Console::output($this->selectOneAddonName());
    }

    /**
     * 激活模块支持i18n
     *
     * @param string $addonName
     *            插件名称
     */
    public function actionI18n()
    {
        $addonName = $this->selectOneAddonName();
        $addonDir = \Yii::getAlias('@Addons/' . $addonName);
        $addonJsonFile = $addonDir . DIRECTORY_SEPARATOR . 'addon.json';
        if (file_exists($addonJsonFile)) {
            $json = json_decode(file_get_contents($addonJsonFile), true);
            $message_category = 'addon_' . Inflector::camel2id($addonName, '_');
            $json['i18n'][] = $message_category;
            $json['i18n'] = array_unique($json['i18n']);
            file_put_contents($addonJsonFile, json_encode($json, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            $msgDir = $addonDir . '/resource/messages/zh-CN/';
            $addonMessageFile = $msgDir . $message_category . '.php';
            if (! is_dir($msgDir)) {
                mkdir($msgDir, 0775, true);
            }
            if (! file_exists($addonMessageFile)) {
                file_put_contents($addonMessageFile, "<?php\nreturn [\n];");
            }
            $this->stdout("激活成功\n" . $addonJsonFile . "\n\n", Console::FG_GREEN);
        } else {
            $this->stdout("激活失败！文件不存在\n" . $addonJsonFile . "\n\n", Console::FG_RED);
        }
    }

    /**
     * 激活模块的属性 'hasApi','hasFrontend','hasBackend','hasConsole'
     */
    public function actionActive()
    {
        $addonName = $this->selectOneAddonName();
        $properties = [
            'hasApi',
            'hasFrontend',
            'hasBackend',
            'hasConsole'
        ];
        $pid = $this->select("请选择要激活的属性,?列出所有选项", $properties);
        $property = $properties[$pid];
        $addonDir = \Yii::getAlias('@Addons/' . $addonName);
        $addonJsonFile = $addonDir . DIRECTORY_SEPARATOR . 'addon.json';
        if (file_exists($addonJsonFile)) {
            $json = json_decode(file_get_contents($addonJsonFile), true);
            $json[$property] = true;
            file_put_contents($addonJsonFile, json_encode($json, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            $this->stdout("激活成功\n" . $addonJsonFile . "\n\n", Console::FG_GREEN);
        } else {
            $this->stdout("激活失败！文件不存在\n" . $addonJsonFile . "\n\n", Console::FG_RED);
        }
    }

    /**
     * 生成插件配置文件
     */
    public function actionConfig()
    {
        list ($addonName, $addonTitle, $addonType) = $this->confirmUserSelect();
        $this->createAddonJsonFile($addonName, $addonTitle, $addonType);
    }

    /**
     * 刷新配置文件
     */
    private function createAddonJsonFile($addonName, $addonTitle, $type = "app")
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
                'author' => "",
                'version' => '1.0.0',
                'intro' => Inflector::camel2words($addonName) . ' ' . $addonTitle,
                'require' => [],
                'i18n' => [],
                'hasApi' => false,
                'hasFrontend' => false,
                'hasBackend' => true,
                'hasConsole' => false,
                'hooksMap' => [],
                'validatorMap' => []
            ];
            $message_category = 'addon_' . Inflector::camel2id($addonName, '_');
            $message_file = $addonDir . '/resource/messages/zh-CN/' . $message_category . '.php';
            echo $message_file, PHP_EOL;
            if (file_exists($message_file)) {
                $addon['i18n'][] = $message_category;
            }
            $data = ArrayHelper::merge($addon, $oldJson);
            file_put_contents($addonJsonFile, json_encode($data, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            $this->stdout("创建成功\n" . $addonJsonFile . "\n\n", Console::FG_GREEN);
        }
    }

    protected function confirmUserSelect()
    {
        $addonName = $this->selectOneAddonName();
        $addonTitle = Inflector::camel2words($addonName);
        $addonType = $this->select("请输入插件的类型", [
            'app' => '完整商业逻辑的插件，比如blog',
            'component' => '有部分商业逻辑，主要是辅助app的插件的功能，比如省份城市的插件',
            'editor' => '编辑器，比如百度编辑器Ueditor',
            'api' => '集成第三方的API,比如存储，支付，短信等'
        ]);
        return [
            $addonName,
            $addonTitle,
            $addonType
        ];
    }

    /**
     * 创建插件
     *
     * @param string $addonName
     *            插件名词
     * @param string $addonTitle
     *            插件标题
     */
    public function actionCreate()
    {
        list ($addonName, $addonTitle, $addonType) = $this->confirmUserSelect();
        $addonDir = \Yii::getAlias('@Addons/' . $addonName);
        $dirs = [
            $addonDir
        ];
        $dirs[] = $addonDir . '/Controllers/Backend';
        $dirs[] = $addonDir . '/Controllers/Frontend';
        $dirs[] = $addonDir . '/Controllers/Api';
        $dirs[] = $addonDir . '/Models';
        $dirs[] = $addonDir . '/DO';
        $dirs[] = $addonDir . '/Hooks';
        $dirs[] = $addonDir . '/Assets';
        $dirs[] = $addonDir . '/Widgets';
        $dirs[] = $addonDir . '/resource';
        $dirs[] = $addonDir . '/resource/messages';
        $dirs[] = $addonDir . '/resource/messages/zh-CN';
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
                $addonMessageFile = $addonDir . '/resource/messages/zh-CN/addon_' . Inflector::camel2id($addonName, '_') . '.php';
                $createMessage = true;
                if (file_exists($addonMessageFile)) {
                    $createMessage = $this->confirm('国际化消息文件已经存在，是否覆盖?');
                }
                if ($createMessage) {
                    file_put_contents($addonMessageFile, "<?php\nreturn " . VarDumper::export([
                        Inflector::camel2words($addonName) => $addonTitle
                    ]) . ';');
                }
                $this->createAddonJsonFile($addonName, $addonTitle, $addonType);
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

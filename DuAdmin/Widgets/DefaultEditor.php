<?php

namespace DuAdmin\Widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use Yii;

class DefaultEditor extends InputWidget
{

    const MODE_DEFAULT = 'default';

    const MODE_RICH = 'rich';

    const MODE_LITTLE = 'little';

    /**
     * 编辑器的模式，控制工具条的丰富性。
     * rich , default, little
     *
     * @var string
     */
    public $mode = 'default';

    public function run()
    {
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            return Html::textarea($this->name, $this->value, $this->options);
        }
    }

    public static function getEditorClass()
    {
        if ($class = AppHelper::getSetting('system.editor.driver')) {
            if (class_exists($class)) {
                return $class;
            } else {
                Yii::debug("system editor widget not found : " . $class);
            }
        }
        return static::class;
    }
}

<?php
namespace DuAdmin\Widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;

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
            return Html::activeTextarea($this->model, $this->attribute, [
                'id' => $this->id,
                'class' => 'form-control'
            ]);
        } else {
            return Html::textarea($this->name, $this->value, [
                'id' => $this->id
            ]);
        }
    }

    public static function getEditorClass()
    {
        if ($class = AppHelper::getSetting('system.editor.driver')) {
            if (class_exists($class)) {
                return $class;
            }
        }
        return static::class;
    }
}

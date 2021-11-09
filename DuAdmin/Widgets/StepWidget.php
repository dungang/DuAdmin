<?php

namespace DuAdmin\Widgets;

use Yii;
use yii\base\Widget;

class StepWidget extends Widget
{

    public $steps = [];
    public function run()
    {
        if (empty($this->steps)) {
            return '';
        }
        $step = Yii::$app->request->get("step", 1);
        $steps = [];
        foreach ($this->steps as $index => $name) {
            $steps[] = [
                'activeClass' => ($step - 1) >= $index ? 'passed' : '',
                'name' => $name
            ];
        }
        return $this->render('steps', ['steps' => $steps]);
    }
}

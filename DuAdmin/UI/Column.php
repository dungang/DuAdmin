<?php
namespace DuAdmin\UI;

class Column extends Layoutable
{

    /**
     * 大小
     *
     * @var integer
     */
    public $size = 6;

    /**
     * 设备尺寸
     *
     * @var array
     */
    public $devices = [
        'sm',
        'md'
    ];

    /**
     * 偏移大小
     *
     * @var integer
     */
    public $offsetSize = 0;

    public function initClass()
    {
        $classNames = [];
        if ($this->offsetSize) {
            foreach ($this->devices as $device) {
                $classNames[] = 'col-' . $device . '-offset-' . $this->offsetSize;
            }
        }

        foreach ($this->devices as $device) {
            $classNames[] = 'col-' . $device . '-' . $this->size;
        }
        $this->class = implode(' ', $classNames);
    }
}


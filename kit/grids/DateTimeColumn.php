<?php

namespace app\kit\grids;

use yii\grid\DataColumn;
use app\kit\widgets\DatePicker;

class DateTimeColumn extends DataColumn
{

    public $format = 'date';

    public $dateFormat = [
        'date' => 'yyyy-mm-dd',
        'datetime' => 'yyyy-mm-dd H:i:s'
    ];

    public function init()
    {
        parent::init();
        $this->headerOptions['width'] = '160px';
    }

    public function setValue($value)
    {
        if (is_array($value)) {
            $this->value = $value[0];
        } else {
            $this->value = $value;
        }
    }
    
    /**
     *
     * {@inheritdoc}
     */
    protected function renderFilterCellContent()
    {
        return DatePicker::widget([
            'model' => $this->grid->filterModel,
            'attribute' => $this->attribute,
            'format' => $this->dateFormat[$this->format]
        ]);
    }
}

<?php
namespace DuAdmin\Grids;

use yii\grid\DataColumn;
use DuAdmin\Widgets\DatePicker;

class DateTimeColumn extends DataColumn
{

    public $format = 'date';

    public $isRange = true;

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
            'format' => $this->dateFormat[$this->format],
            'multidate' => $this->isRange ? 2 : false
        ]);
    }
}

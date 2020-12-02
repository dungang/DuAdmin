<?php
namespace DuAdmin\Grids;

use yii\grid\DataColumn;

/**
 *
 * @author dungang
 *        
 */
class LinkColumn extends DataColumn
{
    public $url;
    
    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
       
    }
}


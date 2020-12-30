<?php
namespace Frontend\Widgets;

use DuAdmin\Widgets\BasePageBlock;

class FeaturesBlock extends BasePageBlock {

    public function renderPageBlock()
    {
        return $this->render('features');
    }
    
    public function initQuery()
    {
        
    }
}
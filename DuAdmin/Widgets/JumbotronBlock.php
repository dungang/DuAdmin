<?php
namespace DuAdmin\Widgets;

class JumbotronBlock extends BasePageBlock
{

    public function renderPageBlock()
    {
        return $this->render('jumbotron', [
            'block' => $this->model
        ]);
    }
    
    public function initQuery()
    {}
}


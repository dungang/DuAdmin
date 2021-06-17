<?php
namespace Addons\Cms\Widgets;

use DuAdmin\Widgets\BasePageBlock;

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


<?php
namespace Frontend\Widgets;

use DuAdmin\Widgets\BasePageBlock;
use Frontend\Forms\ContactForm;

class ContactBlock extends BasePageBlock
{

    public function renderPageBlock()
    {
        return $this->render('@Frontend/views/site/contactForm',['model'=> new ContactForm()]);
    }

    public function initQuery()
    {}
}


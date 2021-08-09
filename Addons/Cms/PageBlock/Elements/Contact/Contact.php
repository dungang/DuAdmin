<?php


namespace Addons\Cms\PageBlock\Elements\Contact;


use Addons\Cms\PageBlock\BaseBlockWidget;
use Frontend\Forms\ContactForm;

/**
 * 联系表单
 * Class Contact
 * @package Addons\Cms\PageBlock\Elements\Contact
 */
class Contact extends BaseBlockWidget
{
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'contact.png';
    public $codeFile = 'contact-code';
    public $isDynamic = true;

    public function prepareLiveCode()
    {
        return $this->renderCodeFile([
            'model' => new ContactForm()
        ]);
    }
}

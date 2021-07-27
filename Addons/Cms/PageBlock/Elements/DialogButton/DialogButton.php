<?php


namespace Addons\Cms\PageBlock\Elements\DialogButton;


use Addons\Cms\PageBlock\BaseBlockWidget;
use DuAdmin\Helpers\AppHelper;

class DialogButton extends BaseBlockWidget
{
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'dialog-button.png';
    public $codeFile = 'dialog-button-code.php';
}
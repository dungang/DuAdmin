<?php


namespace Addons\Cms\PageBlock\Layouts\LeftFullImageSection;


use Addons\Cms\PageBlock\PlaceHolderWidget;

class PlaceHolder extends PlaceHolderWidget
{
    /**
     * @return mixed
     */
    protected function renderBlock()
    {
        return $this->render( 'place-holder' );
    }
}
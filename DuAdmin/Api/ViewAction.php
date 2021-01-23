<?php

namespace DuAdmin\Api;

class ViewAction extends BaseAction
{
    public $newOneOnNotFound = false;

    public $loadFormName = false;
    
    public function run()
    {
      return $this->findModel($this->newOneOnNotFound);
    }
}
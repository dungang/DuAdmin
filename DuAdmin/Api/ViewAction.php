<?php

namespace DuAdmin\Api;

class ViewAction extends BaseAction
{
    public $newOneOnNotFound = false;
    
    public function run()
    {
      return $this->findModel($this->newOneOnNotFound);
    }
}
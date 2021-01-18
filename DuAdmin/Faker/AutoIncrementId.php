<?php
namespace DuAdmin\Faker;

use Faker\Provider\Base;

class AutoIncrementId extends Base {

    private $seed = 1;

    public function id($max){
        if($this->seed > $max) {
            $this->seed = 1;
        }
        return $this->seed++;
    }
}
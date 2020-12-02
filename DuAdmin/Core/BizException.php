<?php

namespace DuAdmin\Core;

use yii\base\Exception;

class BizException extends Exception
{

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'BizException';
    }
}

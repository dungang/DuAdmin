<?php

namespace DuAdmin\Core;

use yii\base\UserException;

class BizException extends UserException
{

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'BizException';
    }
}

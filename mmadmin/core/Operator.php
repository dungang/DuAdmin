<?php
namespace app\mmadmin\core;

interface Operator
{
    /**
     * 获取操作人的ID
     * @return mixed
     */
    public function getOperatorId();
    
    /**
     * 获取操作人的昵称
     * @return string
     */
    public function getOperatorName();
    
}


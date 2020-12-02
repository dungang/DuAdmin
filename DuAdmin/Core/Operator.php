<?php
namespace DuAdmin\Core;

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


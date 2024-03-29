<?php

namespace DuAdmin\Mysql;

use yii\db\ActiveQuery as BaseActiveQuery;

class ActiveQuery extends BaseActiveQuery
{
    public $forUpdate = false;

    public function forUpdate()
    {
        $this->forUpdate = true;
        return $this;
    }


    public function createCommand($db = null)
    {
        return parent::createCommand($db); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function prepare($builder)
    {
        $query = Query::create(parent::prepare($builder), $this->forUpdate);
        return $query;
    }
    
    public function unbufferDb(){
        $unbufferedDb = new \yii\db\Connection([
            'dsn' => \Yii::$app->db->dsn,
            'username' => \Yii::$app->db->username,
            'password' => \Yii::$app->db->password,
            'charset' =>\ Yii::$app->db->charset,
            'tablePrefix' =>\ Yii::$app->db->tablePrefix,
        ]);
        $unbufferedDb->open();
        $unbufferedDb->pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        return $unbufferedDb;
    }
    
    /**
     * 类似 laravel chunk方法
     * 批量查询
     * 注意： 对于 MyISAM，在执行批量查询的过程中，
     * 表可能将被锁， 将延迟或拒绝其他连接的写入操作。 
     * 当使用非缓存查询时，尽量缩短游标打开的时间。
     * 
     * 要禁用缓存并减少客户端内存的需求量，PDO 连接属性 PDO::MYSQL_ATTR_USE_BUFFERED_QUERY 必须设置为 false。 
     * 这样，直到整个数据集被处理完毕前，通过此连接是无法创建其他查询的。 这样的操作可能会阻碍 ActiveRecord 执行表结构查询。 
     * 如果这不构成问题（表结构已被缓存过了）， 
     * 我们可以通过切换原本的连接到非缓存模式，然后在批量查询完成后再切换回来。
     * https://www.yiichina.com/doc/guide/2.0/db-query-builder#batch-query-mysql
     * @param int $size
     * @param callable $callback
     */
    public function chunk($size,$callback){
        foreach($this->batch($size,$this->unbufferDb()) as $key=>$record) {
            if(is_callable($callback)) {
                call_user_func($callback,$record,$key);
            }
        }
    }
    
}

<?php

/**
 * 定义一个链接类型接口类
 * Interface Database
 */
interface Database
{
    public function databaseType();
}

/**
 * Notes: mysql 连接
 * User: LiYi
 * Date: 2019/6/28
 * Time: 23:39
 * Class MysqlDatabase
 */
class MysqlDatabase implements Database
{
    public function databaseType()
    {
        // TODO: Implement databaseType() method.
        return sprintf('mysql:dbname=%s;host=%s;port=%s', 'dbname', 'host', 'port');
    }
}

/**
 * Notes: postgresql 连接
 * User: LiYi
 * Date: 2019/6/28
 * Time: 23:38
 * Class PostgresqlDatabase
 */
class PostgresqlDatabase implements Database
{
    public function databaseType()
    {
        // TODO: Implement databaseType() method.
        return sprintf('postgresql:dbname=%s;host=%s',  'dbname', 'host', 'port');
    }
}

/**
 * Notes: 具体的连接
 * User: LiYi
 * Date: 2019/6/28
 * Time: 23:39
 * Class DatabaseConnect
 */
class DatabaseConnect
{
    public $connect;

    public function __construct(Database $database)
    {
        $this->connect = $database;
    }

    public function getDsn()
    {
        return $this->connect->databaseType();
    }

    public function connection()
    {
        $dsn = $this->getDsn();
        $pdo = new \PDO($dsn, '', '');
        return $pdo;
    }
}

//最后在实现的时候，就可以这样做
$pdo = new DatabaseConnect(new MysqlDatabase());
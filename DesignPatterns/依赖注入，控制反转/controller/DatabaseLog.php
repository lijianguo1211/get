<?php

require 'Logs.php';
class DatabaseLog implements Logs
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('数据库记录日志');
    }

}
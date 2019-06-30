<?php

require 'InterfaceLog.php';
class DatabaseLog implements InterfaceLog
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('数据库日志模式');
    }
}
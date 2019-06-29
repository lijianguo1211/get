<?php

require 'InterfaceLog.php';
class FileLog implements InterfaceLog
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('文件日志模式');
    }
}
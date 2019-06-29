<?php

require 'Logs.php';
class FileLog implements Logs
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('文件记录日志');
    }
}
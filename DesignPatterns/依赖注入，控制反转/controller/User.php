<?php

require 'DatabaseLog.php';
class User
{
    private $file;

    public function __construct(DatabaseLog $log)
    {
        $this->file = $log;
    }

    public function login()
    {
        var_dump('login is success!!!');
        $this->file->write();
    }
}

$user = new User(new DatabaseLog());
$user->login();
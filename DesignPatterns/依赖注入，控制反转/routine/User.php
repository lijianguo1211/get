<?php

require 'FileLog.php';
class User
{
    private $file;

    public function __construct()
    {
        $this->file = new FileLog();
    }

    public function login()
    {
        echo 'login is success!!!';
        $this->file->write();
    }
}

$user = new User();
$user->login();
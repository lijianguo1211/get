<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/11/26 0026 14:05
 */
$status = symlink('./one.php', __DIR__ . '/../test');

var_export($status);

var_dump(linkinfo('./one.php'));
var_dump(readlink('./one.php'));
var_dump(__DIR__);
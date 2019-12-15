<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/12/9 0009 11:59
 */

if (!file_exists('./File.md')) {
    echo "File.md 文件不存在" . PHP_EOL;
}

$fOpenType = fopen('./File.md', 'r');

if (!$fOpenType) {
    echo '打开文件失败：' . PHP_EOL;
}

while ($content = fread($fOpenType, filesize('./File.md'))) {
    echo $content . PHP_EOL;
}

if (!fclose($fOpenType)) {
    echo "关闭文件失败：" . PHP_EOL;
}

var_export(stat('./File.md'));
var_export(fileperms('./File.md'));
//$time = time();
//var_export($time);
//touch('./file.temp', $time + 10, $time + 20);1575873036

var_export(fileatime('./file.temp'));
var_export(filemtime('./file.temp'));


var_dump(filetype('./file.temp'));
var_dump(filetype('./file.md'));
var_dump(filetype('./file.xlsx'));
var_dump(filetype('./..'));

$finfo = finfo_open(FILEINFO_MIME_TYPE);

var_dump(finfo_file($finfo, './file.temp') . ' <==> temp');
var_dump(finfo_file($finfo, './file.md') . ' <==> md');
var_dump(finfo_file($finfo, './file.xlsx') . ' <==> xlsx');
var_dump(finfo_file($finfo, './file.xls') . ' <==> xls');
var_dump(finfo_file($finfo, './file.bmp') . ' <==> bmp');
var_dump(finfo_file($finfo, './file.doc') . ' <==> doc');
var_dump(finfo_file($finfo, './file.docx') . ' <==> docx');
var_dump(finfo_file($finfo, './file.ppt') . ' <==> ppt');
var_dump(finfo_file($finfo, './file.pptx') . ' <==> pptx');
var_dump(finfo_file($finfo, './file.rar') . ' <==> rar');
var_dump(finfo_file($finfo, './file.rtf') . ' <==> rtf');
var_dump(finfo_file($finfo, './file.zip') . ' <==> zip');


$obj = new finfo(FILEINFO_MIME);
var_dump($obj->file('./file.temp') . ' <==> temp');
var_dump($obj->file('./file.md') . ' <==> md');
var_dump($obj->file('./file.xlsx') . ' <==> xlsx');
var_dump($obj->file('./file.xls') . ' <==> xls');
var_dump($obj->file('./file.bmp') . ' <==> bmp');
var_dump($obj->file('./file.doc') . ' <==> doc');
var_dump($obj->file('./file.docx') . ' <==> docx');
var_dump($obj->file('./file.ppt') . ' <==> ppt');
var_dump($obj->file('./file.pptx') . ' <==> pptx');
var_dump($obj->file('./file.rar') . ' <==> rar');
var_dump($obj->file('./file.rtf') . ' <==> rtf');
var_dump($obj->file('./file.zip') . ' <==> zip');

$a = '';

$b = null;

if (isset($a)) {
    echo 123;
} else {
    echo 789;
}

if (isset($b)) {
    echo 456;
} else {
    echo 654;
}

$str = '123qwert123987poiuyjkk123';

//preg_match_all('/[^[:alpha:]]/', $str, $matches1);
preg_match_all('/[^[:alnum:]]/', $str, $matches);

var_dump($matches);
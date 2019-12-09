### 文件相关的函数

* 打开文件或一个资源url `fopen('fileName', 'r|w|x|a|c|r+|w+|x+|a+|c+')` 

* 从文件指针处读取文件 `fread('fopen打开文件的句柄', '读取的长度，或者是字节数')`

* 写入文件 `fwrite('fopen打开文件的句柄', '待写入的字符串', '待写入字符串的长度')`

* 关闭文件资源 `fclose('fopen打开文件的句柄')`

* 判断给定文件名是否是一个目录 `is_dir()`

* 判断文件是否存在 `fiel_exists()`

* 判断给定文件名是否存在并且可读 `is_readable('fileName')`

* 判断给定的文件名是否可写 `is_writable('fileName')`

* 创建目录 `mkdir('文件路径', '权限默认0777', '是否允许递归创建目录，true 是，false 否', '对上下文的支持')`

* 修改目录或者文件权限 `chmod('文件名', '权限')`

* 修改文件的所有者 `chown('文件', '所有者')`

* 修改文件所属组 `chgrp('文件', '组的名称或者数字')`

* 得到文件信息 `stat('fileNamePath')`

* 得到文件权限 `fileperms('fileNamePath')`

* 得到文件路径信息 `pathinfo('fileName','PATHINFO_DIRNAME|PATHINFO_BASENAME|PATHINFO_EXTENSION|PATHINFO_FILENAME')`

* 创建一个新的文件 `touch('fileName', '修改时间', '访问时间')`

* 重命名一个文件或者目录  `rename('oldName', 'newName')`

* 删除文件 `unlink('fileName')`

* 删除目录 `rmdir('dirName')`

##### 得到文件类型

* 扩展 fileinfo-ext

* 方式一：面向过程

```php
<?php

$fileinfo = finfo_open(FILEINFO_MIME_TYPE);

var_dump(finfo_file($fileinfo, 'fileName'));

```

* 方式二：面向对象

```php
<?php

$obj = new Finfo(FILEINFO_MIME);

var_dump($obj->file('FileName'));
```


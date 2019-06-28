### laravel-excel 导入学习

* excel导入和导出差不多，首先我们都需要一个控制器，一个对外提供接口的方法。如下：

```php
<?php

class LiYIController
{
    public function importExcel()
    {
        $file = request()->file('liyi');
        Excel::import(new LiYiImport(), $file);
    }
}
```

> 在导入的方法中，可能我们需要做的多一点的就是要求我们还要做文件上传操作，所以参数可能稍微多一点

* 处理导入类逻辑，创建 php artisan make:import LiYiImport

调用的`import()`方法

```php
    /**
    *参数一：$import 导入处理逻辑类
     
     参数二：$filePath 上传文件的路径
     
     参数三：$disk 这个是磁盘，也就是我们的文件如果就在服务器上，需要它，或者说，上传的文件先存到磁盘
            然后再从磁盘上导入，就需要它，如果是直接上传导入，就直接为默认值null，就可以了
     
     参数四：代表导入的文件类型，和导出的一样，在Maatwebsite\Excel\Excel中有定义       
    */
    public function import($import, $filePath, string $disk = null, string $readerType = null)
    {
        $readerType = FileTypeDetector::detect($filePath, $readerType);
        $response   = $this->reader->read($import, $filePath, $readerType, $disk);

        if ($response instanceof PendingDispatch) {
            return $response;
        }

        return $this;
    }
```

接着看`FileTypeDetector::detect($filePath, $readerType)`方法，
第一判断文件类型参数是否为null,不全等于null,就代表已经制定了，return 直接返回。否则接续

第二：判断我们传的文件路径是否是UploadedFile这中类型的接口，或者是继承它的接口。如果是，就可以直接使用
getClientOriginalExtension()方法，得到上传文件的后缀。如果不是，也就是代表从磁盘导入的，那就需要pathinfo()函数解析文件的路径，
最后使用pathinfo($filePath)['extension'] 得到文件的后缀。

第三：判断传入的指定的文件类型是否为null，并且把得到的后缀去掉空白字符后和空字符比较，如果这一步为真，那么本次导入结束，否则第四步

第四：用得到的后置去excel.php配置文件匹配我们得到的文件类型

```php
    /**
        参数一：上一步传过来的文件路径
        
        参数二：调用import()上传的路径，默认为null
    */
    public static function detect($filePath, string $type = null)
    {
        if (null !== $type) {
            return $type;
        }

        if (!$filePath instanceof UploadedFile) {
            $pathInfo  = pathinfo($filePath);
            $extension = $pathInfo['extension'] ?? '';
        } else {
            $extension = $filePath->getClientOriginalExtension();
        }

        if (null === $type && trim($extension) === '') {
            throw new NoTypeDetectedException();
        }

        return config('excel.extension_detector.' . strtolower($extension));
    }
```

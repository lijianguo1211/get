### laravel-excel使用

* 官网 [官方文档](https://docs.laravel-excel.com/)

* composer [composer下载地址](require maatwebsite/laravel-excel-light)

* 安装所需要的PHP扩展和composer依赖扩展

```json
  "require": {
    "ext-json": "*",
    "php": "^7.0",
    "phpoffice/phpspreadsheet": "^1.6",
    "illuminate/support": "5.5.*|5.6.*|5.7.*|5.8.*",
    "opis/closure": "^3.1"
  },
  "require-dev": {
    "phpunit/phpunit": "^8.0",
    "mockery/mockery": "^1.1",
    "orchestra/testbench": "^3.8",
    "orchestra/database": "^3.8",
    "predis/predis": "^1.1"
  }
```
这里的laravel需要的`phpoffice/phpspreadsheet`composer包，所以还需要安装它，它需要的php扩展

```php
"require": {
        "php": "^5.6|^7.0",
        "ext-ctype": "*",
        "ext-dom": "*",
        "ext-gd": "*",
        "ext-iconv": "*",
        "ext-fileinfo": "*",
        "ext-libxml": "*",
        "ext-mbstring": "*",
        "ext-SimpleXML": "*",
        "ext-xml": "*",
        "ext-xmlreader": "*",
        "ext-xmlwriter": "*",
        "ext-zip": "*",
        "ext-zlib": "*",
        "psr/simple-cache": "^1.0",
        "markbaker/complex": "^1.4",
        "markbaker/matrix": "^1.1"
    },
```

#### 导出

* 创建一个到出类，在这个具体的导出里面写导出逻辑   `php artisan make:export LiYiExport` 后面可以加参数`--model=`

1. 集合导出，这个需要继承接口 `use Maatwebsite\Excel\Concerns\FromCollection;`

```php
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LiYiExport implements FromCollection
{
    public function collection()
    {
        // TODO: Implement collection() method.
        /*
         * 实现一：以model类的查询方法 all();
         * LiYiModel::all();
         */

        if (!true) {
            return $result = LiYiModel::all();
        }
        /**
         * 实现二：自己构造一个二维数组，
         */
        $result = [
            [1,2,3],
            [4,5,6],
            [7,8,9]
        ];

        return new Collection($result);
    }
}
```

这里看到一个`Collection`类，他是`class Collection extends BaseCollection implements QueueableCollection`,
继承自`class Collection implements ArrayAccess, Arrayable, Countable, IteratorAggregate, Jsonable, JsonSerializable`,
在`Collection`的构造方法里：
```php
    public function __construct($items = [])
    {
        $this->items = $this->getArrayableItems($items);
    }
    
    protected function getArrayableItems($items)
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof Arrayable) {
            return $items->toArray();
        } elseif ($items instanceof Jsonable) {
            return json_decode($items->toJson(), true);
        } elseif ($items instanceof JsonSerializable) {
            return $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array) $items;
    }
```

2. 数组导出，这个需要继承接口 `use Maatwebsite\Excel\Concerns\FromArray;`

```php
class LiYiExport implements FromArray
{
    public function array(): array
    {
        $result = [
             [1,2,3],
             [4,5,6],
             [7,8,9]
                ];
    }
}
```

3. laravel 的orm查询数据导出，这个需要继承接口 `use Maatwebsite\Excel\Concerns\FromQuery;`

```php
class LiYiExport implements FromQuery
{
    public function query()
    {
        return LIYiModel::query()->select()->where()->orderBy();
    }
}
```

> 注意:在query()方法中，一定不要使用orm方法的get()方法。它的下面操作需要用到chunk()方法，就是说它是把导出分为不同的小块执行，在chunk()方法中，
第一个参数是每次处理的数量大小，第二个参数是一个闭包。

4. 迭代器导出，这个需要继承接口 `use Maatwebsite\Excel\Concerns\FromIterator;`

```php
class LiYiExport implements FromIterator
{
    public function iterator(): Iterator
    {
        
    }
}
```

* 对外调用导出，创建一个控制器，提供一个外部调用的方法；

1. 导出到本地
```php
<?php
/**
 * Notes:
 * File name:DownloadExcel
 * Create by: Jay.Li
 * Created on: 2019\6\18 0018 11:51
 */

use Maatwebsite\Excel\Facades\Excel;

class DownloadExcel
{
    /**
     * Notes: 下载到本地
     * Function Name: downloadWindows
     * User: Jay.Li
     * Date: 2019\6\18 0018
     * Time: 11:53
     */
    public function downloadWindows()
    {
        /**
         * 参数一：导出逻辑类
         * 参数二：导出文件名
         * 参数二：导出文件格式，默认为null，导出的是xslx格式，
         * 参数二：导出设置额外的header参数默认为空，数组形式
         */
        Excel::download(new LiYiExport(), 'test.csv','','');
    }
}

```
2. 导出到磁盘
```php
<?php
/**
 * Notes:
 * File name:DownloadExcel
 * Create by: Jay.Li
 * Created on: 2019\6\18 0018 11:51
 */

use Maatwebsite\Excel\Facades\Excel;

class DownloadExcel
{
    /**
     * Notes: 下载到磁盘，下载到服务器上
     * Function Name: downloadStore
     * User: Jay.Li
     * Date: 2019\6\18 0018
     * Time: 11:55
     */
    public function downloadStore()
    {
        /**
         * 参数一：下载具体的逻辑类
         * 参数二：下载的文件名
         * 参数三：下载到磁盘的那个磁盘上，指定磁盘
         * 参数四：下载导出的格式，默认不填写为null，也就是Excel::XLSX
         * 参数五：传递给磁盘的参数，数组形式的参数
         *
         */
        Excel::store(new LiYiExport(), 'test.csv', 's3',Excel::XLSX,'');
    }
}
```

* 导出格式，虽然这个扩展包的名字是`laravel-excel`,但是它并不是只支持excel,还支持很多种格式的文件，在`Maatwebsite\Excel\Excel`文件中有
定义：

```php
class Excel implements Exporter, Importer
{
    use RegistersCustomConcerns;

    const XLSX     = 'Xlsx';

    const CSV      = 'Csv';

    const TSV      = 'Csv';

    const ODS      = 'Ods';

    const XLS      = 'Xls';

    const SLK      = 'Slk';

    const XML      = 'Xml';

    const GNUMERIC = 'Gnumeric';

    const HTML     = 'Html';

    const MPDF     = 'Mpdf';

    const DOMPDF   = 'Dompdf';

    const TCPDF    = 'Tcpdf';
}    
```

* 设置自己所需要的标题行，这个需要继承接口 `use Maatwebsite\Excel\Concerns\WithHeadings;`

```php
class LiYiExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return LIYiModel::query()->select()->where()->orderBy();
    }
    
    public function headings(): array
    {
        return [
            '第一行',
            '第二行',
            '第三行',
        ];
    }
}
```
> handings()方法返回的是一个数组，它可以是一个一维数组，也可以是一个二维数组，二维数组就是返回多行

* 设置导出样式，这个需要继承接口 `use Maatwebsite\Excel\Concerns\WithEvents;use Maatwebsite\Excel\Events\AfterSheet;`

```php
class LiYiExport implements FromQuery, WithHeadings, AfterSheet
{
    public function query()
    {
        return LIYiModel::query()->select()->where()->orderBy();
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                //获取当前sheet工作表
                $workSheet = $event->sheet()->getDelegate();
                //设置表头字体为16；
                $cellRange = 'A1:W1';
                $workSheet->getStyle($cellRange)->getFont()->getSize(16);

                // 将样式数组应用于B2：G8范围单元格
                $styleArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ]
                    ]
                ];

                //获取总行数
                $end = $workSheet->getCellCollection()->getHighestRow();

                $cellRangeContent = 'A2:W'.$end;
                //设置表格样式
                $workSheet->getStyle($cellRangeContent)->applyFromArray($styleArray);

                //设置内容行的宽度

                $arrayColumn = [
                    'B' => 30,
                    'D' => 60,
                    'G' => 90,
                ];
                foreach ($arrayColumn as $k => $item) {
                    //获取特定的列，设置它的宽度
                    $workSheet->getColumnDimension($k)->setWidth($item);
                }

                //设置自动换行，文本居中
                $workSheet->getStyle($cellRangeContent)->getAlignment()
                    ->setWrapText(true)->setVertical("center")
                    ->setHorizontal("center");
            }
        ];
    }
}
```

> 这里面有两点需要注意：1。registerEvents();这个函数是一个数组，2.键值是`Maatwebsite\Excel\Events\AfterSheet`这个类,闭包函数依赖注入
`use Maatwebsite\Excel\Events\AfterSheet;`通过它的构造函数：
```php
    public function __construct(Sheet $sheet, $exportable)
    {
        $this->sheet      = $sheet;
        $this->exportable = $exportable;
    }
```
> 注入`Maatwebsite\Excel\Sheet`
```php
    public function __construct(Worksheet $worksheet)
    {
        $this->worksheet            = $worksheet;
        $this->chunkSize            = config('excel.exports.chunk_size', 100);
        $this->temporaryFileFactory = app(TemporaryFileFactory::class);
    }
```


****************************

[github地址](https://github.com/lijianguo1211/lijianguo/blob/phpmd/php/frame/laravel/laravel-excel/laravel-excel.md)
欢迎大家交流学习


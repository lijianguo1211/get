### Laravel `illuminate/database` 组件的SQL日志打印

* 基于`illuminate/database` 5.0

在低版本的组件里，有一个事件监听字符 ``illuminate.query``,

```php
public function listen(Closure $callback)
{
    if (isset($this->events))
    {
        $this->events->listen('illuminate.query', $callback);
    }
}
```

传入一个闭包，然后就可以打印所有的SQL语句，实例：

```php
<?php

<?php
/**
 * Notes:
 * File name:DataBaseServe
 * Create by: Jay.Li
 * Created on: 2019/11/11 0011 9:38
 */


namespace App\Serve;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

class DataBaseServe
{
    public $databaseServe = null;

    public function __construct()
    {
        $this->databaseServe = new Capsule();
        $this->initDatabase();
    }

    public function initDatabase()
    {
        $this->databaseServe->addConnection(require __DIR__ . '/../../config/database.php');
        $this->databaseServe->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $this->databaseServe->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->databaseServe->bootEloquent();
        $this->databaseServe::connection()->listen(function($query, $bindings, $spend) {
            // Insert bindings into query
            $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
            //var_dump($query);
            $query = vsprintf($query, $bindings);

            //$query = $sql;

            // Save the query to file
            $logFilePath = __DIR__ .'/../../storage/logs/'. DIRECTORY_SEPARATOR . date('Y-m-d') . '-query.log';
            $logFile = fopen($logFilePath, 'a+');
            fwrite($logFile, date('Y-m-d H:i:s') . ': spend=[' . $spend . '] ' . $query . PHP_EOL);
            fclose($logFile);
        });
    }
}
```

最主要的就是这个事件监听：它可以传入四个参数：

1. 第一参数：执行的sql语句，参数绑定的形式，基本是以问好代替参数的形式

2. 第二参数：参数的绑定数组

3. 第三参数：sql执行的时间

```php
$this->databaseServe::connection()->listen(function($query, $bindings, $spend) {
            // Insert bindings into query
            $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
            
            $query = vsprintf($query, $bindings);

            // Save the query to file
            $logFilePath = __DIR__ .'/../../storage/logs/'. DIRECTORY_SEPARATOR . date('Y-m-d') . '-query.log';
            $logFile = fopen($logFilePath, 'a+');
            fwrite($logFile, date('Y-m-d H:i:s') . ': spend=[' . $spend . '] ' . $query . PHP_EOL);
            fclose($logFile);
        });
```

最后把参数替换到sql中，输出完整的sql到日志中

* 基于 `illuminate/database` 5.5

事件监听函数，传递闭包处理，传递的`$query`就包含了sql和绑定的参数以及时间

```php
<?php

$this->databaseServe::connection()->listen(function($query) {
            // Insert bindings into query
            foreach($query->bindings as $key => $binding) {
                if ($binding instanceof DateTime) {
                    $bindings[$key] = $binding->format( '\'Y-m-d H:i:s\'' );
                } elseif (is_string($binding)) {
                    $bindings[$key] = "'$binding'";
                }   
            }
            $query = str_replace(array('%', '?'), array('%%', '%s'), $query->sql);
            
            $sql = vsprintf($query, $query->bindings);

            // Save the query to file
            $logFilePath = __DIR__ .'/../../storage/logs/'. DIRECTORY_SEPARATOR . date('Y-m-d') . '-query.log';
            $logFile = fopen($logFilePath, 'a+');
            fwrite($logFile, date('Y-m-d H:i:s') . ': spend=[' . $query->time . '] ' . $sql . PHP_EOL);
            fclose($logFile);
        });
```
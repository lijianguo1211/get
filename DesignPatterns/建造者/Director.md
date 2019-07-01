### 建造者模式

**复杂的问题简单细节化**

有一个大的加工厂，生产各式各样的汽车，汽车厂目前有五个不萌，所有车辆都是经过这五个部门出去的。`interface BuilderInterface{}`

1. 汽车一部：设计立项部，主要负责规划怎么生产汽车，得到生产计划，分发任务. `createVehicle()`

2. 汽车二部：汽车轮廓生产部。`addDoors()`

3. 汽车三部：汽车轮子生产部. `addWheel()`

4. 汽车四部：汽车引擎生产部. `addEngine()`

5. 汽车五部：最后检验部，得到完整的车辆，出厂. `getVehicle()`

当然了,这个汽车里不至生产一种汽车,它规定了一种生产标准,剩下的就是要去具体的实现了.刚好呢我们这个汽车厂,符合要求的标准的呢就要有是那种,
* 一是生产小汽车,小汽车生产部 ``class CarBuilder implements BuilderInterface{}``
* 二是生产卡车,卡车生产部 ``class TruckBuilder implements BuilderInterface{}``
* 三是生产跑车,跑车生产部 ``class SportsCarBuilder implements BuilderInterface{}``

由于人民的消费水平增高，买车的人越来越多，生产规模扩大，生产线增多，所以厂子的目前产能已经跟不上销售了，所以，厂里董事局
研究决定，对汽车二三四部做进一步的扩大生产线投资.现在把:

* 汽车轮廓生产部扩大经营, 
```php
class Door
{
    public $door;

    public function __construct($message)
    {
        $this->door = $message;
        var_dump($message);
    }
}
```
* 汽车轮子生产部扩大经营,
```php
class Wheel
{
    public $wheel;

    public function __construct($message)
    {
        $this->wheel = $message;
        var_dump($message);
    }
}
```
* 汽车引擎生产部扩大经营,
```php
class Engine
{
    public $engine;

    public function __construct($message)
    {
        $this->engine = $message;
        var_dump($message);
    }
}
```

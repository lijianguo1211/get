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
研究决定，对汽车二三四部做进一步的扩大生产线投资。现在我们把生产线分离出去，也就是说这个大的造车集团，总领前进的路线，但是一些细节东西会把它
分离出去，核心技术掌握在手，但是这些造螺丝按钮的小活，重新建厂，于是就有一下的:

* 汽车轮廓生产部扩大经营, ----汽车轮廓分公司
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
* 汽车轮子生产部扩大经营,----汽车轮子分公司
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
* 汽车引擎生产部扩大经营,----汽车引擎分公司
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

上面这些虽然都分离了出去，但是最后的组装还是要人来做呀，所以现在集团决定再建立一个代工厂中心 
```php
abstract class Vehicle
{
    private $data = [];

    public function setPart($key, $value)
    {
        $this->data[$key] = $value;
    }
}
```

这个代工厂就和富士康有点类似，承包各种流水线的组装生产。它是一个大型的综合的组装中心。但是又有不同的厂部，比如富士康，它有苹果的生产线，有华为
的生产线，有魅族的生产线。。。那么我们这个汽车组装的生产线呢也有它的规划，目前董事局考虑的是三条生产线

1. 小轿车生产线

```php
class Car extends Vehicle
{

}
```

2. 货车生产线

```php
class Truck extends Vehicle
{

}
```

3. 跑车生产线

```php
class SportsCar extends Vehicle
{

}
```

经过上面这面这样的研究拆分，我们的汽车生产厂，就变成了一个汽车集团。对于生产的汽车产能有了保障。质量有了保证。利益也有了保证，简直是一举夺得，
这个例子呢和我们的建造者模式很相像。

* 最后调用

```php
$truckBuilder = new TruckBuilder();
$newVehicle = (new Director())->build($truckBuilder);
var_dump($newVehicle);


$carBuilder = new CarBuilder();
$newVehicle = (new Director())->build($carBuilder);

var_dump($newVehicle);
```

*************************

举例可能不恰当，但是个人觉得还是比较形象的，这个大白话来看的话，设计模式还是很好理解的,加油！！！

[github文档地址，欢迎大家指教交流](https://github.com/lijianguo1211/get/blob/master/DesignPatterns/%E5%BB%BA%E9%80%A0%E8%80%85/Director.md)

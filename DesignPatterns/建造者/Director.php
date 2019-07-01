<?php

/**
 * 定义接口，制造车的接口
 * Interface BuilderInterface
 */
interface BuilderInterface
{
    /**
     * Notes: 创造一个车
     * Name: createVehicle
     * User: LiYi
     * Date: 2019/7/1
     * Time: 22:07
     * @return mixed
     */
    public function createVehicle();

    /**
     * Notes: 给车添加轮子
     * Name: addWheel
     * User: LiYi
     * Date: 2019/7/1
     * Time: 22:07
     * @return mixed
     */
    public function addWheel();

    /**
     * Notes: 添加引擎
     * Name: addEngine
     * User: LiYi
     * Date: 2019/7/1
     * Time: 22:08
     * @return mixed
     */
    public function addEngine();

    /**
     * Notes: 添加门
     * Name: addDoors
     * User: LiYi
     * Date: 2019/7/1
     * Time: 22:08
     * @return mixed
     */
    public function addDoors();

    /**
     * Notes:制造完成,出厂
     * Name: getVehicle
     * User: LiYi
     * Date: 2019/7/1
     * Time: 22:08
     * @return mixed
     */
    public function getVehicle();
}

/**
 * Notes: 实现一，制造卡车类
 * User: LiYi
 * Date: 2019/7/1
 * Time: 22:02
 * Class TruckBuilder
 */
class TruckBuilder implements BuilderInterface
{
    private $truck;

    public function addDoors()
    {
        // TODO: Implement addDoors() method.
        $this->truck->setPart('doors', new Door('卡车门'));
    }

    public function addEngine()
    {
        // TODO: Implement addEngine() method.
        $this->truck->setPart('engine', new Engine('卡车引擎'));
    }

    public function addWheel()
    {
        // TODO: Implement addWheel() method.
        $this->truck->setPart('wheel', new Wheel('卡车轮子'));
    }

    public function createVehicle()
    {
        // TODO: Implement createVehicle() method.
        $this->truck = new Truck();
    }

    public function getVehicle()
    {
        // TODO: Implement getVehicle() method.
        return $this->truck;
    }
}

/**
 * Notes: 实现二，制造小轿车类
 * User: LiYi
 * Date: 2019/7/1
 * Time: 22:03
 * Class CarBuilder
 */
class CarBuilder implements BuilderInterface
{
    private $car;

    public function addDoors()
    {
        // TODO: Implement addDoors() method.
        $this->car->setPart('doors', new Door('小车门'));
    }

    public function addWheel()
    {
        // TODO: Implement addWheel() method.
        $this->car->setPart('wheelLf', new wheel('小车轮子'));
    }

    public function addEngine()
    {
        // TODO: Implement addEngine() method.
        $this->car->setPart('engine', new Engine('小车引擎'));
    }

    public function createVehicle()
    {
        // TODO: Implement createVehicle() method.
        $this->car = new Car();
    }

    public function getVehicle()
    {
        // TODO: Implement getVehicle() method.
        return $this->car;
    }
}

/**
 * Notes: 抽象类组装
 * User: LiYi
 * Date: 2019/7/1
 * Time: 22:03
 * Class Vehicle
 */
abstract class Vehicle
{
    private $data = [];

    public function setPart($key, $value)
    {
        $this->data[$key] = $value;
    }
}

class Truck extends Vehicle
{

}

class Car extends Vehicle
{

}

/**
 * Notes: 具体实现造引擎的细节
 * User: LiYi
 * Date: 2019/7/1
 * Time: 22:10
 * Class Engine
 */
class Engine
{
    public $engine;

    public function __construct($message)
    {
        $this->engine = $message;
        var_dump($message);
    }
}

/**
 * Notes: 具体实现造轮子的细节
 * User: LiYi
 * Date: 2019/7/1
 * Time: 22:09
 * Class Wheel
 */
class Wheel
{
    public $wheel;

    public function __construct($message)
    {
        $this->wheel = $message;
        var_dump($message);
    }
}

/**
 * Notes: 具体实现造轮子的细节
 * User: LiYi
 * Date: 2019/7/1
 * Time: 22:09
 * Class Door
 */
class Door
{
    public $door;

    public function __construct($message)
    {
        $this->door = $message;
        var_dump($message);
    }
}


class Director
{
    public function build(BuilderInterface $builder):Vehicle
    {
        $builder->createVehicle();
        $builder->addEngine();
        $builder->addWheel();
        $builder->addDoors();

        return $builder->getVehicle();
    }
}

$truckBuilder = new TruckBuilder();
$newVehicle = (new Director())->build($truckBuilder);
var_dump($newVehicle);


$carBuilder = new CarBuilder();
$newVehicle = (new Director())->build($carBuilder);

var_dump($newVehicle);











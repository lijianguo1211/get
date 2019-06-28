<?php

class SimpleInterest
{
    /**
     * Notes: 存储单利对象
     * class_name: SimpleInterest
     * User: LiYi
     * Date: 2019/6/28
     * Time: 23:05
     * @var null
     */
    private static $instance = null;

    /**
     * 防止实例化
     * SimpleInterest constructor.
     */
    private function __construct()
    {

    }

    /**
     * Notes:防止克隆
     * Name: __clone
     * User: LiYi
     * Date: 2019/6/28
     * Time: 23:01
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * Notes: 防止反序列化
     * Name: __wakeup
     * User: LiYi
     * Date: 2019/6/28
     * Time: 23:01
     */
    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    /**
     * Notes: 对外提供的公开访问方法，懒加载，在类第一次调用的时候，实例化
     * Name: getInstance
     * User: LiYi
     * Date: 2019/6/28
     * Time: 23:03
     * @return null
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new self();
        }

        return static::$instance;
    }
}
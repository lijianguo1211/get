<?php

/**
 * 观察者
 * Interface Observer
 */

abstract class EventGuan
{
    protected $observers = [];

    public $obj;

    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * Notes: 添加
     * Name: addOberser
     * User: LiYi
     * Date: 2019/6/30
     * Time: 19:18
     * @param Observers $observer
     */
    public function addOberser(Observers $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * Notes: 通知
     * Name: notfiy
     * User: LiYi
     * Date: 2019/6/30
     * Time: 19:18
     */
    public function notfiy()
    {
        foreach ($this->observers as $key =>  $observer) {
            var_dump($key);
            var_dump($observer);
            //$observer->handle();
            (new $observer())->handle(new $key($this->obj));
        }
    }
}

class EventLiYi extends EventGuan
{
    protected $observers = [
        UserEvent::class => UserListener::class
    ];
}


class User
{
    public function index(string $messgae)
    {
        var_dump('调用index方法');
        var_dump($messgae);
    }
}

interface EventInterface
{

}

class UserEvent implements EventInterface
{
    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }
}

interface ListenerInterface
{
    public function handle(EventInterface $event);
}

class UserListener implements ListenerInterface
{
    public function handle(EventInterface $event)
    {
        try {
            //处理逻辑
            var_dump('处理逻辑');
            var_dump($event->event);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}


function event($params) {
    return (new EventLiYi($params))->notfiy();
}


$user = (new User())->index('miss you');
$user_event = new UserEvent(['hahah']);
event($user_event);
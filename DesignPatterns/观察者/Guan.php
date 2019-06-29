<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019\6\29 0029 11:14
 */
class Guan implements \SplSubject
{

    private $obj;

    public function __construct()
    {
        $this->obj = new \SplObjectStorage();
    }

    /**
     * Notes:添加一个观察者
     * Function Name: attach
     * User: Jay.Li
     * Date: 2019\6\29 0029
     * Time: 11:39
     * @param Observer $observer
     * @return mixed
     */
    public function attach(\SplObserver $observer)
    {
        return $this->obj->attach($observer);
    }

    /**
     * Notes: 删除一个观察者
     * Function Name: detach
     * User: Jay.Li
     * Date: 2019\6\29 0029
     * Time: 11:39
     * @param Observer $observer
     * @return mixed
     */
    public function detach(\SplObserver $observer)
    {
        return $this->obj->detach();
    }

    /**
     * Notes: 通知一个观察者
     * Function Name: notfiy
     * User: Jay.Li
     * Date: 2019\6\29 0029
     * Time: 11:39
     * @return mixed
     */
    public function notify()
    {
        foreach ($this->obj as $observer) {
            $observer->update($this);
        }
    }
}


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

    private $email;

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

    public function changeEmail($email)
    {
        $this->email = $email;
        $this->notify();
    }
}


class UserObserver implements \SplObserver
{
    private $changeUsers = [];

    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        $this->changeUsers[] = clone $subject;
        var_dump('登陆了');
    }

    public function getChangeUsers()
    {
        return $this->changeUsers;

    }
}

$observer = new UserObserver();

$user = new Guan();

$user->attach($observer);

$user->changeEmail('153@qq.com');

var_dump($observer->getChangeUsers());
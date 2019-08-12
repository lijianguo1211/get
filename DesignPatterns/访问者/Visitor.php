<?php

/**
 * 抽象访问者
 * Interface VisitorInterface
 */
interface VisitorInterface
{
    public function vistUser(User $user);

    public function vietGroup(Group $group);
}

/**
 * Notes:具体访问者
 * User: LiYi
 * Date: 2019/7/28
 * Time: 16:14
 * Class Visitor
 */
class Visitor implements VisitorInterface
{
    private $visitor = [];

    public function vietGroup(Group $group)
    {
        // TODO: Implement vietGroup() method.
        $this->visitor[] = $group;
    }

    public function vistUser(User $user)
    {
        // TODO: Implement vistUser() method.
        $this->visitor[] = $user;
    }

    public function getVisitor():array
    {
        return $this->visitor;
    }
}

/**
 * 抽象元素
 * Interface Role
 */
interface Role
{
    public function accept(VisitorInterface $visitor);
}

/**
 * Notes: 具体元素之用户
 * User: LiYi
 * Date: 2019/7/28
 * Time: 16:15
 * Class User
 */
class User implements Role
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function accept(VisitorInterface $visitor)
    {
        // TODO: Implement accept() method.
        $visitor->vistUser($this);
    }

    public function getName():string
    {
        return sprintf('User is: %s', $this->name);
    }
}

/**
 * Notes: 具体元素之分组
 * User: LiYi
 * Date: 2019/7/28
 * Time: 16:15
 * Class Group
 */
class Group implements Role
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function accept(VisitorInterface $visitor)
    {
        // TODO: Implement accept() method.
        $visitor->vietGroup($this);
    }

    public function getName():string
    {
        return sprintf('Group is: %s', $this->name);
    }
}


/**
 * Notes:对象结构
 * User: LiYi
 * Date: 2019/7/28
 * Time: 16:15
 * Class test
 */
class test
{
    private $visitor;

    public function __construct()
    {
        $this->visitor = new Visitor();
    }



    public function index(Role $role)
    {
        $role->accept($this->visitor);

        $dd = $this->visitor->getVisitor();

        foreach ($dd as $item) {
            var_dump($item->getName());
        }
    }
}

$obj = new test();

  $user = new User('LIYI');
  $group = new Group('Administrators');


$obj->index($user);
$obj->index($group);
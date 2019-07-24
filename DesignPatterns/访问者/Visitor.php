<?php

interface VisitorInterface
{
    public function vistUser(User $user);

    public function vietGroup(Group $group);
}

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

interface Role
{
    public function accept(VisitorInterface $visitor);
}

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

        var_dump($dd);
    }
}

$obj = new test();

  $user = new User('LIYI');
  $group = new Group('Administrators');


$obj->index($user);
$obj->index($group);
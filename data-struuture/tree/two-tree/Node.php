<?php

class Node
{
    private $id;

    private $name;

    private $left = null;

    private $right = null;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLeft($left)
    {
        $this->left = $left;
    }

    public function setRight($right)
    {
        $this->right = $right;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return sprintf("当前节点是：%d, name是：%s", $this->id, $this->name);
    }
}

$node1 = new Node(1, 'liyi');
$node2 = new Node(2, 'liyi2');
$node3 = new Node(3, 'liyi3');
$node4 = new Node(4, 'liyi4');
$node2->setLeft($node4);
$node1->setLeft($node2);
$node1->setRight($node3);
var_dump($node1);

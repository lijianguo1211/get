<?php

require './Node.php';

class TreeNode
{
    private $root = null;

    public function __construct(Node $root = null)
    {
        $this->root = $root;
    }

    public function middleTree()
    {
        if ($this->root != null) {
            $this->root->middleTree();
        } else {
            var_dump('tree is empty');
        }
    }

    public function postTree()
    {
        if ($this->root != null) {
            $this->root->postTree();
        } else {
            var_dump('tree is empty');
        }
    }

    public function preorderTree()
    {
        if ($this->root != null) {
            $this->root->preorderTree();
        } else {
            var_dump('tree is empty');
        }
    }
}

$node1 = new Node(1, 'liyi');
$node2 = new Node(2, 'liyi2');
$node3 = new Node(3, 'liyi3');
$node4 = new Node(4, 'liyi4');
$node2->setLeft($node4);
$node1->setLeft($node2);
$node1->setRight($node3);
$tree = new TreeNode();
var_dump($tree->preorderTree());
var_dump($tree->middleTree());
var_dump($tree->postTree());

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

    /**
     * 1.先输出root节点
     * 2.判断当前节点的左子节点是否为空，如果不为空，递归遍历
     * 3.判断当前节点的右子节点是否为空，如果不为空，递归遍历
     * Notes:前序遍历
     * Name: preorderTree
     * User: LiYi
     * Date: 2020/1/5
     * Time: 19:10
     */
    public function preorderTree()
    {
        echo $this;

        if ($this->left !=  null) {
            $this->left->preorderTree();
        }

        if ($this->right != null) {
            $this->right->preorderTree();
        }
    }

    /**
     * Notes:中序遍历
     * Name: middleTree
     * User: LiYi
     * Date: 2020/1/5
     * Time: 19:10
     */
    public function middleTree()
    {
        if ($this->left !=  null) {
            $this->left->preorderTree();
        }

        echo $this;

        if ($this->right != null) {
            $this->right->preorderTree();
        }
    }

    /**
     * Notes:后续遍历
     * Name: postTree
     * User: LiYi
     * Date: 2020/1/5
     * Time: 19:10
     */
    public function postTree()
    {
        if ($this->left !=  null) {
            $this->left->preorderTree();
        }

        if ($this->right != null) {
            $this->right->preorderTree();
        }

        echo $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return sprintf("当前节点是：%d, name是：%s \n", $this->id, $this->name);
    }
}


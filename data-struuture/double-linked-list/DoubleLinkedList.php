<?php


class DoubleLinkedList
{
    /*
     object head 指针，指向头节点，不变也不能被赋值
    */
    private $head;

    public function __construct()
    {
        $this->head = new HeadNote(0 ,'', '');
    }

    public function add(HeadNote $headNote)
    {
        //辅助指针，初始话指向头节点
        $temp = $this->head;

        while(true) {
            if ($temp->next === null) {
                break;//链表遍历结束
            }
            $temp = $temp->next;//指针后移
        }
        $headNote->prev = $temp;//待插入节点的prev指针指向临时节点
        $temp->next = $headNote;//临时节点的next指针指向待插入节点
    }

    public function update(HeadNote $headNote)
    {
        $temp = $this->head->next;
        $flag = false;

        while (true) {
            if ($temp === null) {
                break;
            }

            if ($temp->id = $headNote->id) {
                $flag = true;
                break;
            }

            $temp = $temp->next;
        }

        if ($flag) {
            $temp->name = $headNote->name;
            $temp->nickname = $headNote->nickname;
        } else {
            return print_r('待修改节点不存在');
        }
    }

    public function del(int $id)
    {
        //临时指针，初始指向头节点的下一个节点
        $temp = $this->head->next;
        //记录状态的变量，初始为false
        $flag = false;

        while (true) {
            if ($temp === null) {
                break;//代表链表遍历结束
            }

            if ($temp->id === $id) {
                $flag = true;
                break;//找到了链表中节点ID
            }
            //指针后移
            $temp = $temp->next;
        }

        if ($flag) {
            //改变指针next和prev的指向
            $temp->prev->next = $temp->next;
            if ($temp->next !== null) {
                //如果待删除节点就是最后一个节点，那么把待删除节点的前一个节点next指向待删除节点的下一个
                //节点没有问题，也就是null.
                //但是待删除的节点就是最后一个节点。那么它的next就是指向null,null的前一个节点，这时程序
                //就会报错。所以需要做判断，是否待删除节点就是最后一个节点
                $temp->next->prev = $temp->prev;
            }
        } else {
            return printf("链表中不存在节点ID为：$id 的节点");
        }
    }

    public function list()
    {
        // 判断链表是否为空
        if ($this->head === null) {
            return printf('链表为空');
        }
        $temp = $this->head->next;

        while (true) {
            //判断链表是否到最后
            if ($temp === null) {
                break;
            }
            //输出节点信息
            var_dump($temp->prev);
            //将指针temp后移
            $temp = $temp->next;
        }
    }
}

require 'HeadNote.php';
$test1 = new HeadNote(1, 'liyi', 'yiyiy');
$test2 = new HeadNote(3, 'haha', 'hahaha');
$test3 = new HeadNote(2, 'haha', 'hahaha');
$test4 = new HeadNote(4, 'haha', 'hahaha');
$test5 = new HeadNote(5, 'liyi', 'yiyiy');

$obj = new DoubleLinkedList();

$obj->add($test1);
$obj->add($test2);
$obj->add($test3);
$obj->add($test4);
$obj->add($test5);

$obj->list();
echo "\n";
$obj->del(3);
$obj->list();
echo "\n";
$obj->del(1);
$obj->list();
echo "\n";
$obj->del(5);
$obj->list();
echo "\n";
$test6 = new HeadNote(2, '王二', '王二麻子');
$obj->update($test6);
$obj->list();
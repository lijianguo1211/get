<?php


class AnnularLinkedList
{
    private $first = null;

    public function add(int $num)
    {
        if ($num < 1) {
            return printf("创建环行链表的个数不能小于1，当前输入是：%d\n", $num);
        }
        //$num 代表环行的大小
        require 'HeadNode.php';
        //辅助指针，第一个节点不能移动，因此创建一个辅助指针，辅助指针最开始指向第一个节点，
        $temp = new HeadNode(-1, '');
        for ($i = 1; $i <= $num; $i++) {
            $uuid = uniqid('uuid_');
            $body = new HeadNode($i, $uuid);
            if ($i === 1) {
                //创建第一个节点，first节点，它的next指针指向自己
                $this->first = $body;
                $this->first->setNext($this->first);
                $temp = $this->first;//辅助指针指向第一个节点
            } else {
                $temp->setNext($body);//创建下一个节点的时候，辅助指针指向下一个节点
                $body->setNext($this->first);//下一个节点的指针永远指向第一个节点
                $temp = $body;//辅助指针后移
            }

        }
        //初始化环形链表的第一个节点
    }

    public function list()
    {
        if ($this->first === null) {
            return printf("链表没有数据");
        }

        //辅助指针，指向第一个节点
        $temp = $this->first;

        while (true) {
            printf("小孩的编号 %d,唯一uuid是：%s \n", $temp->getNum(), $temp->getUuid());
            print_r($temp->getNext());
            if ($temp->getNext() == $this->first) {
                // 当辅助指针的next指针指向第一个节点，说明已经遍历完毕
                break;
            }
            $temp = $temp->getNext(); // 辅助指针后移
        }
    }
}

$obj = new AnnularLinkedList();

$obj->add(10);

//print_r($obj);
$obj->list();
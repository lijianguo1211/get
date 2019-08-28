<?php


class LinkedList
{
    //添加一个头节点，头节点初始化后不会变
    private $head;

    public function __construct()
    {
        $this->head = new HeadNodel(0, '', '');
    }

    /**
     * Notes:添加节点都单项链表
     * Name: add
     * User: LiYi
     * Date: 2019/8/29
     * Time: 0:17
     * @param HeadNodel $headNodel
     */
    public function add(HeadNodel $headNodel)
    {
        //1.找到当前来链表的最后一个节点
        //2.将最后这个节点的next节点指向新的节点

        //定义一个临时指针
        $temp = $this->head;

        while (true) {
            //找到链表最后
            if ($temp->next === null) {
                break;
            }
            //没有找到，next 后移
            $temp = $temp->next;
        }
        //退出while循环，代表指针temp指向了链表的最后
        $temp->next = $headNodel;
    }

    /**
     * Notes:打印链表
     * Name: getList
     * User: LiYi
     * Date: 2019/8/29
     * Time: 0:17
     * @return int
     */
    public function getList()
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
            printf($temp);
            //将指针temp后移
            $temp = $temp->next;
        }
    }
}

class HeadNodel
{
    public $no;

    public $name;

    public $nickname;

    public $next = null;

    public function __construct(int $hNum, string $hName, string $hNickname)
    {
        $this->no = $hNum;
        $this->name = $hName;
        $this->nickname = $hNickname;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return sprintf("编号是：%d,英雄是：%s,昵称是：%s, 下一个节点是：%s\n",
            $this->no,
            $this->name,
            $this->nickname,
            $this->next
        );
    }
}

$test1 = new HeadNodel(1, '宋江', '及时雨');
$test2 = new HeadNodel(2, '卢俊义', '玉麒麟');
$test3 = new HeadNodel(3, '吴用', '智多星');
$test4 = new HeadNodel(4, '林冲', '豹子头');
$test5 = new HeadNodel(5, '武松', '打虎');

$obj = new LinkedList();
$obj->add($test1);
$obj->add($test2);
$obj->add($test3);
$obj->add($test4);
$obj->add($test5);

$obj->getList();
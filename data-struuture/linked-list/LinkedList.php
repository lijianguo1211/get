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
     * Notes: 添加指定顺序的节点
     * Name: addByOrder
     * User: LiYi
     * Date: 2019/9/1
     * Time: 23:04
     * @param HeadNodel $headNodel
     * @return string
     */
    public function addByOrder(HeadNodel $headNodel)
    {
        //头节点不能动，通过辅助指针，来找到添加的位置
        //单链表，找的辅助指针，是位于辅助指针的前一个节点
        $temp = $this->head;
        $flag = false;//标识，标识是否存在

        while (true) {
            if ($temp->next === null) {
                break;//代表最后一个节点
            }

            if ($temp->next->no > $headNodel->no) {
                //代表要插入的节点编号小于后一个节点标号，所以可以插入了,退出循环
                break;
            } elseif ($temp->next->no === $headNodel->no) {
                //代表要插入的节点编号已经存在
                $flag = true;
                break;
            }
            $temp = $temp->next;//后移，继续遍历
        }

        if ($flag) {
            //编号存在，不能添加
            return printf("准备插入的编号已存在，不能插入待插入节点id：$headNodel->no\n");
        } else {
            //新添加节点的next域 = 把临时指针的next域指
            $headNodel->next = $temp->next;

            //把临时节点的next域指向新插入节点
            $temp->next = $headNodel;
        }
    }

    /**
     * Notes: 根据id修改节点，
     * Name: updateNode
     * User: LiYi
     * Date: 2019/9/1
     * Time: 23:14
     * @param HeadNodel $headNodel
     * @return string
     */
    public function updateNode(HeadNodel $headNodel)
    {
        if ($this->head->next === null) {
            return sprintf('链表为空');
        }

        //定义一个辅助节点
        $temp = $this->head->next;
        $flag = false;

        while (true) {
            if ($temp->next === null) {
                break;//遍历结束
            }

            if ($temp->no === $headNodel->no) {
                $flag = true;//找到了
                break;
            }
        }

        if ($flag) {
            //修改
            $temp->name = $headNodel->name;
            $temp->nickname = $headNodel->nickname;
        } else {
            return sprintf('链表中不存在该节点');
        }
    }

    /**
     * Notes: 删除节点
     * Name: deleteNode
     * User: LiYi
     * Date: 2019/9/1
     * Time: 23:27
     * @param int $num
     * @return string
     */
    public function deleteNode(int $num)
    {
        //单链表删除节点
        //定义一个辅助节点，找到待删除节点的前一个节点
        //temp->next = temp->next->next
        //比较 temp->next->no 和待删除节点的no比较
        $temp = $this->head;
        $flag = false;//代表是否找到节点
        while (true) {
            if ($temp->next === null) {
                break;//遍历到最后一个节点
            }

            if ($temp->next->no === $num) {
                $flag = true;//找到待删除节点
                break;
            }

            $temp = $temp->next;
        }

        if ($flag) {
            $temp->next = $temp->next->next;
        } else {
            return sprintf('没有找到待删除节点');
        }
    }

    /**
     * Notes:带头链表的有效节点个数
     * Name: getLengthLinked
     * User: LiYi
     * Date: 2019/9/1
     * Time: 23:41
     * @return int
     */
    public function getLengthLinked() :int
    {
        if ($this->head->next === null) {
            return 0;
        }

        $length = 0;
        $temp = $this->head->next;

        while ($temp != null) {
            $length++;
            $temp = $temp->next;
        }

        return $length;
    }


    /**
     * Notes:查找单链表的倒数第k个节点
     * Name: findLastIndexNode
     * User: LiYi
     * Date: 2019/9/2
     * Time: 0:03
     * @param int $index 表示倒数第几个节点
     * @return null | HeadNodel
     */
    public function findLastIndexNode(int $index)
    {
        // $index
        // 从头到尾的遍历，得到链表有效节点个数（长度）$size
        // 得到链表长度后，再次遍历链表，遍历链表长度$size-$index 个
        if ($this->head->next === null) {
            return null;
        }

        //链表长度
        $size = $this->getLengthLinked();

        if ($index <= 0 || $index > $size) {
            return null;
        }

        //遍历
        $cur = $this->head->next;
        for ($i = 0; $i < $size-$index; $i++) {
            $cur = $cur->next;
        }

        return $cur;
    }

    public function deleteLastIndexNode(int $index)
    {
        //链表长度
        $size = $this->getLengthLinked();
        $temp = $this->head;

        $size -= $index;

        while ($size > 0) {
            $size--;
            $temp = $temp->next;
        }
        $temp->next = $temp->next->next;
    }


    //反转单链表 思路
    //1.定义一个新的链表 reverseHead = new HeroHead();
    //2.从头遍历原来的链表，美遍历一个节点，将其取出，并放在新的链表的最前端
    //3.原来的链表 head->next = reverseHead->next;
    public function reverseLinedList(HeadNodel $linkedList)
    {
        if ($this->head->next === null || $this->head->next->next === null) {
            return printf('链表为空或链表只有一条数据');
        }
        //辅助指针
        $temp = $this->head->next;
        //指向当前节点[$temp]的下一个节点
        $next = null;
        $reverseHead = $linkedList;//辅助新的链表

        //遍历原来的链表
        while ($temp != null) {
            $next = $temp->next;//保存当前节点的下一个节点
            $temp->next = $reverseHead->next;//将辅助指针的下一个节点指向新链表的最前端
            $reverseHead->next = $temp;
            $temp = $next;//辅助指针后移
        }
        //将$this->head->next = $reverseHead->next
        $this->head->next = $reverseHead->next;
    }

    public function printfLinkedList()
    {
        if ($this->head->next === null) {
            return printf('链表为空');
        }
        $temp = [];
        $linked = $this->head->next;
        while ($linked != null) {
            array_push($temp, serialize($linked));
            $linked = $linked->next;
        }
        while (count($temp) > 0) {
            $str = array_pop($temp);
            printf(unserialize($str));
        }
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
        return sprintf("编号是：%d,英雄是：%s,昵称是：%s\n",
            $this->no,
            $this->name,
            $this->nickname
            //$this->next
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

echo "删除倒数某个节点前 . \n";
$obj->getList();

$obj->deleteLastIndexNode(2);
echo "删除倒数某个节点后 . \n";
$obj->getList();
echo "#### . \n";


$obj->addByOrder($test1);
$obj->addByOrder($test5);
$obj->addByOrder($test1);
$obj->addByOrder($test5);
$obj->addByOrder($test3);
$obj->addByOrder($test4);
$obj->addByOrder($test2);

$obj->getList();
echo "\n";
echo $obj->findLastIndexNode(1);

echo "\n";
echo $obj->getLengthLinked();
echo "\n";
$obj->reverseLinedList(new HeadNodel(0, '', ''));
echo "\n";
$obj->getList();
echo "\n";
$obj->printfLinkedList();
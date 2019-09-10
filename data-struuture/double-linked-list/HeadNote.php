<?php


class HeadNote
{
    /*
     void next 指针，指向下一个节点
    */
    public $next = null;

    /*
     void prev 指针，指向上一个节点
    */
    public $prev = null;

    /*
     int id id序号
    */
    public $id;

    /*
     string name 名字
    */
    public $name;

    /*
     string nickname 昵称
    */
    public $nickname;

    /**
     * HeadNote constructor.节点构造方法
     * @param int $id
     * @param string $name
     * @param string $nickname
     */
    public function __construct(int $id, string $name, string $nickname)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
    }

    /**
     * Notes: 以字符串输出
     * Name: __toString
     * User: LiYi
     * Date: 2019/9/9
     * Time: 23:28
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return sprintf("编号是：%d,英雄是：%s,昵称是：%s\n",
            $this->id,
            $this->name,
            $this->nickname
        //$this->next
        );
    }
}
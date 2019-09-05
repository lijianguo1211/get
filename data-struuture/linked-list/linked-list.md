### 链表学习


* 链表以节点的方式来存储

* 每个节点包含data域，next域，指向下一个节点

* 链表分为带头结点和不带头节点

* 链表不一定是连续存储的

**head** 头节点，表示链表的头(头节点不存放具体的数据，但是头结点也不能改变)

**next** 单链表的指针，指向下一个节点

**链表的最后一个节点** 默认是不存放数据，留空，可以设置为 `null`

#### 具体做法

* 申明一个类存放每一个节点数据的类，这个节点的数据`data`可以是任意数据，这里我可以声明一个存放任务的类，`HeadNode`,然后可以默认先存放
人物的`ID`,名字`name`,昵称`nickname`,指向下一个节点的指针`next`等等。。。

>代码实现：

```php
<?php

class HeadNode
{
    /**
    * @var int  人物ID
     */
    public $id;
    
    /**
    * @var string 人物名字 
     */
    public $name;
    
    /**
    * @var string 人物昵称
     */
    public $nickname;
    
    /**
    * @var null 指向下一个节点，默认为null，代表下一个节点为空
     */
    public $next = null;
    
    /**
    * HeadNode constructor.初始化给每一个节点赋值添加数据
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
    Notes:以字符串的形式输出类的具体信息
    Function Name: __toString
    User: Jay.Li
    Date: 2019\9\5 0005
    Time: 9:48
     */
    public function __toString()
    {
    // TODO: Implement __toString() method.
        return sprintf("人物的ID是：%d\t, 人物的名字是：%s\t, 人物的昵称是：%s\t", $this->id, $this->name, $this->nickname);
    }
}
```

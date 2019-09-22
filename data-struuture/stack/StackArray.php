<?php


class StackArray
{
    /**
     * 栈的大小
     * @var int
     */
    private $maxSize;

    /**
     * 数组栈
     * @var array
     */
    private $stack = [];

    /**
     * 栈顶，默认是-1，代表没有数据
     * @var int
     */
    public $top = -1;

    /**
     * 初始化栈的大小
     * StackArray constructor.
     * @param int $maxSize
     */
    public function __construct(int $maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function pop()
    {
        if ($this->isEmpty()) {
            throw new Exception("栈空，没有数据\n");
        }
        $tmp = $this->stack[$this->top];
        $this->top--;
        return $tmp;
    }

    public function push(int $num)
    {
        if ($this->isFull()) {
            return printf("栈满，不能添加数据\n");
        }
        $this->top++;
        $this->stack[$this->top] = $num;
        return $this->top;
    }

    public function getList()
    {
        for ($i = $this->maxSize-1; $i > $this->top; $i--) {
           echo sprintf("stack[%d] = %d", $this->top, $this->stack[$i]);
        }
    }

    /**
     * Notes:判断栈是否为空
     * User: LiYi
     * Date: 2019/9/17 0017
     * Time: 9:48
     * @return bool
     */
    public function isEmpty():bool
    {
        return $this->top === -1;
    }

    /**
     * Notes: 判断栈是否已满
     * User: LiYi
     * Date: 2019/9/17 0017
     * Time: 9:42
     * @return bool
     */
    public function isFull():bool
    {
        return count($this->stack) === $this->maxSize;
    }
}

$obj = new StackArray(5);

$obj->push(10);
$obj->push(20);
$obj->push(30);
$obj->push(40);
$obj->push(50);
var_dump($obj->getList());
try {
    var_dump($obj->pop());
    var_dump($obj->pop());
    var_dump($obj->pop());
    var_dump($obj->pop());
    var_dump($obj->pop());
    var_dump($obj->pop());
} catch (\Exception $e) {
    var_dump($e->getMessage());
}

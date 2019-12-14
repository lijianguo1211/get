<?php

class fibonacci
{
    private $tempData = [];

    /**
     * Notes: F(n) = F(n-1) + F(n-2)  n > 2
     * User: LiYi
     * Date: 2019/12/14 0014
     * Time: 9:50
     * @param int $size
     */
    public function makeFibonacciArray(int $size)
    {
        $this->tempData[0] = 1;
        $this->tempData[1] = 1;

        for ($i = 2; $i <= $size; $i++) {
            $this->tempData[$i] = $this->tempData[$i - 1] + $this->tempData[$i - 2];
        }
    }

   public function __toString()
   {
       // TODO: Implement __toString() method.
       return implode(',', $this->tempData) . PHP_EOL;
   }
}


$obj = new fibonacci();
$obj->makeFibonacciArray(30);
var_dump($obj);


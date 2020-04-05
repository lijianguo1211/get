### 求和

>给定一个整数数组 nums 和一个目标值 target，请你在该数组中找出和为目标值的那 两个 整数，并返回他们的数组下标。
你可以假设每种输入只会对应一个答案。但是，你不能重复利用这个数组中同样的元素。
 示例:
 给定 nums = [2, 7, 11, 15], target = 9
 因为 nums[0] + nums[1] = 2 + 7 = 9
 所以返回 [0, 1]

```php
<?php
$nums = [2, 7, 11, 15];
$target = 9;
function sums($nums, $target)                       
{                                                   
    $count = count($nums);                          
    $arr = [-1];                                    
    for ($i = 0; $i < $count; $i++) {               
        for ($j = $i + 1; $j < $count; $j++) {      
            if ($target - $nums[$i] == $nums[$j]) { 
                $arr = [$i, $j];                    
            }                                       
        }                                           
    }                                               
    return $arr;                                    
}  

function sums2($data, $target)                                                             
{                                                                                          
    $temp = [];//定义一个临时数组                                                                  
    foreach ($data as $k => $item) {                                                       
        $diffValue = $target - $item;//得到差值，                                               
        if (!isset($temp[$diffValue])) {//判断差值是否在临时数组中,                                    
            $temp[$item] = $k;//如果不在临时数组中，把当前循环的值放入临时数组当作键，键当作值，                           
            continue;//跳出本次循环                                                              
        }                                                                                  
        return [$temp[$diffValue], $k];                                                    
    }                                                                                      
    return [-1];                                                                           
}                                                                                          

                                                 
```

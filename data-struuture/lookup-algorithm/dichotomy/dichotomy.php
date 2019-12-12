<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/12/11 0011 17:00
 */
class dichotomy
{
    /**
     * Notes: 查找一个值就退出
     * User: LiYi
     * Date: 2019/12/12 0012
     * Time: 14:34
     * @param array $data
     * @param int $leftIndex
     * @param int $rightIndex
     * @param int $findValue
     * @return array|false|float|int
     */
    public function searchValue(array $data, int $leftIndex, int $rightIndex, int $findValue)
    {
        if (!is_array($data)) {
            return ['message' => '非数组', 'status' => 0];
        }

        $middleIndex = floor(($leftIndex + $rightIndex) / 2);//中间值的键
        $middleValue = $data[$middleIndex];//中间值

        /**
         * 递归结束条件
         */
        if ($leftIndex > $rightIndex) {
            return -1;
        }

        if ($findValue > $middleValue) {
            return $this->searchValue($data, $middleIndex + 1, $rightIndex, $findValue);
        } elseif ($findValue < $middleValue) {
            return $this->searchValue($data, $leftIndex, $middleIndex - 1, $findValue);
        } else {
            return $middleIndex;
        }
    }

    /**
     * Notes:查找到所有的值再退出
     * User: LiYi
     * Date: 2019/12/12 0012
     * Time: 14:35
     * @param array $data
     * @param int $leftIndex
     * @param int $rightIndex
     * @param int $findValue
     * @return array|int
     */
    public function searchValue2(array $data, int $leftIndex, int $rightIndex, int $findValue)
    {
        if (!is_array($data)) {
            return ['message' => '非数组', 'status' => 0];
        }
        $arr = [];
        $middleIndex = floor(($leftIndex + $rightIndex) / 2);//中间值的键
        if ($middleIndex < $leftIndex || $middleIndex > $rightIndex) {
            return ['message' => sprintf("该 [%d] 值不在数组内", $findValue), 'status' => 0];
        }
        $middleValue = $data[$middleIndex];//中间值

        /**
         * 递归结束条件
         */
        if ($leftIndex > $rightIndex) {
            return $arr[] = -1;
        }

        if ($findValue > $middleValue) {
            return $this->searchValue2($data, $middleIndex + 1, $rightIndex, $findValue);
        } elseif ($findValue < $middleValue) {
            return $this->searchValue2($data, $leftIndex, $middleIndex - 1, $findValue);
        } else {
            $tempLeft = $middleIndex - 1;
            while (true) {
                //向左循环，得到所有相同的键
                if ($tempLeft < $leftIndex || $data[$tempLeft] != $middleValue) {
                    break;
                }

                array_push($arr, $tempLeft);
                $tempLeft--;
            }
            array_push($arr, $middleIndex);

            $tempRight = $middleIndex + 1;
            while (true) {
                //向右循环，得到所有相同的键
                if ($tempRight > $rightIndex || $data[$tempRight] != $middleValue) {
                    break;
                }
                array_push($arr, $tempRight);
                $tempRight++;
            }
            return $arr;
        }
    }

    public function searchValue3(array $data, int $findValue)
    {
        $leftIndex = 0;
        $rightIndex = count($data) - 1;

        while ($leftIndex <= $rightIndex) {
            $middleIndex = intval($leftIndex + ($rightIndex - $leftIndex) / 2);//中间值的键

            if ($middleIndex < $leftIndex || $middleIndex > $rightIndex) {
                return ['message' => sprintf("该 [%d] 值不在数组内", $findValue), 'status' => 0];
            }
            if ($findValue < $data[$middleIndex]) {
                $leftIndex = $middleIndex - 1;
            }
            if ($findValue > $data[$middleIndex]) {
                $rightIndex = $middleIndex + 1;
            }
            if ($findValue == $data[$middleIndex]) {
                return $middleIndex;
            }
        }
        return -1;
    }
}

try {
    $obj = new dichotomy();
    $data = [2,3,5,8,8,8,45,99];
    //$leftIndex = 0;
    //$rightIndex = count($data) - 1;
    //$middleIndex = (int)floor(($leftIndex + $rightIndex) / 2);//中间值的键
    //var_dump($middleIndex);
    //$data = [20,50,60,70,80,90,100,280,290,390,490,490,590,590,590,590,590,690,790,890,990,1000,10101,1000000];
    //var_dump($obj->searchValue3($data, 5));
    //var_dump($obj->searchValue2($data, 0, count($data) - 1, 100000011));
    //var_dump($obj->searchValue2($data, 0, count($data) - 1, 590));
} catch (\Exception $e) {
    var_dump($e->getMessage());
}

var_dump("###### start time: " . microtime(true));
try {
    $zipFile = 'dichotomy.zip';

    $zip = new \ZipArchive();

    $res = $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

    if ($res !== true) {
        var_dump('error: ' . getMessage($res));
    }
    $path = 'http://jayli.whgxwl.com:6060/';

    for ($i = 2; $i < 7; $i++) {
        // 初始化一个 curl
        $ch = curl_init();
        // 设置请求的 url
        curl_setopt($ch, CURLOPT_URL, $path . $i . '.pdf');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 不直接输出，而是通过 curl_exec 返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (false === ($stream = curl_exec($ch))) {
            throw new \Exception(curl_errno($ch));
        }

        curl_close($ch);

        file_put_contents("./$i.pdf", $stream);
    }

    $download = __DIR__;

    $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($download));

    foreach ($files as $name => $file)
    {
        // 我们要跳过所有子目录
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = 'dichotomy/' . substr($filePath, strlen($path) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
var_dump("###### end time: " . microtime(true));
function getMessage(int $code)
{
    switch($code){
        case ZipArchive::ER_EXISTS:
            $ErrMsg = "File already exists.";
            break;
        case ZipArchive::ER_INCONS:
            $ErrMsg = "Zip archive inconsistent.";
            break;
        case ZipArchive::ER_MEMORY:
            $ErrMsg = "Malloc failure.";
            break;
        case ZipArchive::ER_NOENT:
            $ErrMsg = "No such file.";
            break;
        case ZipArchive::ER_NOZIP:
            $ErrMsg = "Not a zip archive.";
            break;
        case ZipArchive::ER_OPEN:
            $ErrMsg = "Can't open file.";
            break;
        case ZipArchive::ER_READ:
            $ErrMsg = "Read error.";
            break;
        case ZipArchive::ER_SEEK:
            $ErrMsg = "Seek error.";
            break;
        default:
            $ErrMsg = "Unknow (Code file)";
            break;
    }

    return $ErrMsg;
}
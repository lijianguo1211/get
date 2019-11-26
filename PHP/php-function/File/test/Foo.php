<?php
/**
 * Notes:
 * File name:Foo
 * Create by: Jay.Li
 * Created on: 2019/11/26 0026 14:39
 */

//require __DIR__ . '../vendor/autoload.php';

use Psr\Log\LoggerInterface;

class Foo
{
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    public function doSomething()
    {
        if ($this->logger) {
            $this->logger->info('Doing work');
        }

        try {
            $this->doSomethingElse();
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            $this->logger->error('Oh no!', array('exception' => $exception));
        }

        // do something useful
    }
}
try {
    $test = new Foo();
    //$test->doSomething();
} catch (\Exception $e) {
    var_dump($e->getMessage());
}

$test1 = ['jay', 'li', 'yi'];

$test2 = 'hello world!!!';

$temp = compact('test1', 'test2');

var_export($temp);
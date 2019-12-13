<?php

use Psr\Log\AbstractLogger;

/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/11/26 0026 14:45
 */

class FileLogs implements FileLogInterface, LogLevelInterface
{
    protected $stream = null;

    protected $level;

    protected $errorMessage;

    public function __construct($stream, $level = LogLevelInterface::DEBUG)
    {
        if (!is_string($stream)) {
            throw new LogException(sprintf("给定的%s不是一个规定的字符", $stream));
        }

        $this->stream = $stream;
        $this->level = $level;
    }

    protected function write(array $record)
    {
        $this->createDir();
        set_error_handler(array($this, 'customErrorHandler'));
        $this->stream = fopen($this->stream, 'a');
        @chmod($this->stream, '0666');
        restore_error_handler();
        if (!is_resource($this->stream)) {
            $this->stream = null;
            throw new LogException(sprintf('The stream or file "%s" could not be opened: '.$this->errorMessage, $this->stream));
        }

        $this->streamWrite($this->stream, $record);
    }

    /**
     * Notes: 创建文件
     * User: LiYi
     * Date: 2019/11/26 0026
     * Time: 15:44
     */
    public function createDir()
    {
        $pos = strpos($this->stream, '://');
        if ($pos !== false) {
            return false;
        }
        $dir = dirname($this->stream);
        set_error_handler(array($this, 'customErrorHandler'));
        $status = mkdir($dir, 0777, true);
        restore_error_handler();
        if (false === $status && !is_dir($dir)) {
            throw new LogException(sprintf('There is no existing directory at "%s" and its not buildable: '.$this->errorMessage, $dir));
        }

        return true;
    }

    /**
     * Notes:输出自定义错误
     * User: LiYi
     * Date: 2019/11/26 0026
     * Time: 16:31
     * @param $code
     * @param $message
     */
    public function customErrorHandler($code, $message)
    {
        $this->errorMessage = preg_replace('{^(fopen|mkdir)\(.*?\): }', '', $message);
    }


    protected function streamWrite($stream, array $record)
    {
        fwrite($stream, (string) $record['formatted']);
    }
}

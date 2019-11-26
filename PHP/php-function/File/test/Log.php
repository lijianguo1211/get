<?php

use Psr\Log\LoggerInterface;

/**
 * Notes:
 * File name:
 * Create by: Jay.Li
 * Created on: 2019/11/26 0026 14:42
 */


class Log implements LoggerInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function writeLog($level, $message, $context)
    {
        $this->logger->{$level}($message, $context);
    }

    public function write($level, $message, $context)
    {
        $this->writeLog($level, $message, $context);
    }

    public function emergency($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function alert($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function info($message, array $context = array())
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->writeLog($level, $message, $context);
    }
}
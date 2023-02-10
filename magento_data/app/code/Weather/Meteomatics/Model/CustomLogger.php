<?php

namespace AdvancedCoder\ProductTypes\Model;

use Psr\Log\LoggerInterface;

class CustomLogger implements LoggerInterface
{
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function emergency($message, array $context = array())
    {
        $this->logger->emergency($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function alert($message, array $context = array())
    {
        $this->logger->alert($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function critical($message, array $context = array())
    {
        $this->logger->critical($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function error($message, array $context = array())
    {
        $this->logger->error($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function warning($message, array $context = array())
    {
        $this->logger->warning($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function notice($message, array $context = array())
    {
        $this->logger->notice($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function info($message, array $context = array())
    {
        $this->logger->info($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function debug($message, array $context = array())
    {
        $this->logger->debug($message, $context);
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void|null
     */
    public function log($level, $message, array $context = array())
    {
        $this->logger->log($message, $context);
    }
}

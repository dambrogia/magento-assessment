<?php

namespace Assessment\SimpleQueue\Logger;

use Consolidation\Log\Logger;
use Magento\Framework\Logger\Handler\Base;

/**
 * Class ConsumerLoggerHandler
 * Custom Handler for Logger
 * @package Assessment\SimpleQueue\Logger
 */
class ConsumerLoggerHandler extends Base
{
    /**
     * Log level for custom log handler
     * @var string
     */
    protected $loggerType = Logger::INFO;

    /**
     * Output path of log file
     */
    protected $fileName = '/var/log/consumer.log';
}

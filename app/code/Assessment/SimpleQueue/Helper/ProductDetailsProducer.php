<?php

namespace Assessment\SimpleQueue\Helper;

use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

/**
 * Class ProductDetailsProducer
 * Helper class responsible for publishing to queue
 * @package Assessment\SimpleQueue\Helper
 */
class ProductDetailsProducer
{
    const TOPIC_NAME = 'retrieve.product.details';

    /**
     * @var Json
     */
    protected $_json;

    /**
     * @var PublisherInterface
     */
    protected $_publisher;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * ProductDetailsProducer constructor.
     * @param PublisherInterface $publisher
     * @param Json $json
     * @param LoggerInterface $logger
     */
    public function __construct(
        PublisherInterface $publisher,
        Json $json,
        LoggerInterface $logger
    )
    {
        $this->_publisher = $publisher;
        $this->_json = $json;
        $this->_logger = $logger;
    }

    /**
     * Product message into configured topic
     * @param $entityId
     */
    public function produce($entityId)
    {
        try {
            $rawData = ['entity_id' => $entityId];
            $this->_publisher->publish(self::TOPIC_NAME, $this->_json->serialize($rawData));
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());
        }
    }
}

<?php

namespace Assessment\SimpleQueue\Model\Queue;

use Assessment\SimpleQueue\Logger\ConsumerLogger;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class ProductDetailsConsumer
 * Consumes Message from Queue and processes them.
 * @package Assessment\SimpleQueue\Model\Queue
 */
class ProductDetailsConsumer
{
    /**
     * @var ConsumerLogger
     */
    protected $_logger;

    /**
     * @var Json
     */
    protected $_json;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * ProductDetailsConsumer constructor.
     * @param ConsumerLogger $logger
     * @param Json $json
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ConsumerLogger $logger,
        Json $json,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->_logger = $logger;
        $this->_json = $json;
        $this->productRepository = $productRepository;
    }

    /**
     * Loads product by entityId and log out sku details
     *
     * Note: Decided to go with productRepository instead of ResourceConnection since a
     * table join is not required and cost of query is very minimal
     * @param $productDetailsMessage
     */
    public function execute($productDetailsMessage)
    {
        try {
            $message = $this->_json->unserialize($productDetailsMessage);
            $productEntityId = $message['entity_id'];
            /** @var \Magento\Catalog\Api\Data\ProductInterface $product */
            $product = $this->productRepository->getById($productEntityId);
            $this->_logger->info('Product Sku: ' . $product->getSku());
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());
        }
    }
}

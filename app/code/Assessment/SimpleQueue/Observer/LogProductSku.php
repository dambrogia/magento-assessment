<?php

namespace Assessment\SimpleQueue\Observer;

use Assessment\SimpleQueue\Helper\ProductDetailsProducer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class LogProductSku
 * Frontend Event Handler, captures productId and
 * produces a publish request to using publish helper
 * @package Assessment\SimpleQueue\Observer
 */
class LogProductSku
    implements ObserverInterface
{
    /**
     * @var ProductDetailsProducer
     */
    protected $helper;

    /**
     * PublishToDetailsQueue constructor.
     * @param ProductDetailsProducer $helper
     */
    public function __construct(
        ProductDetailsProducer $helper
    )
    {
        $this->helper = $helper;
    }

    /**
     * Standard Execute function retrieves product entity Id
     * from Observer Event and utilizes Helper Producer to publish message
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $productId = (int)$observer->getEvent()->getProduct()->getId();
        $this->helper->produce($productId);
    }
}

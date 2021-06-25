<?php

namespace Assessment\SimpleQueue\Console\Command;

use Assessment\SimpleQueue\Helper\ProductDetailsProducer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DeleteProductIdsCommand
 * Defines our custom command and execute instructions
 * @package Assessment\SimpleQueue\Console\Command
 */
class PublishToDetailsQueueCommand extends Command
{
    const ARG_PRODUCT_ID = 'entity_id';

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
        parent::__construct();
        $this->helper = $helper;
    }

    /**
     * Configuration for the custom command.
     */
    protected function configure()
    {
        $this->setName('simple:queue:publish')
            ->setDescription('Publish Product Entity Id to Consumer Queue for processing!')
            ->addArgument(self::ARG_PRODUCT_ID, InputArgument::REQUIRED, 'Product Entity ID');
    }

    /**
     * Function validates for valid non zero int value before publishing
     * message using helper class
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = (int)$input->getArgument(self::ARG_PRODUCT_ID);
        if ($id !== 0) {
            $this->helper->produce($id);
            $output->writeln("Published Entity Id to Message Queue!");
        } else {
            $output->writeln("Invalid Entity Id was provided, EntityId must be a non zero integer value");
        }
    }
}

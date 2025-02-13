<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace HarveyNorman\PromotionalProducts\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use HarveyNorman\PromotionalProducts\Model\Backend\Publisher;
use Psr\Log\LoggerInterface;

/**
 * CLI command class to trigger consumer for Promotional Products
 */
class TriggerUpdates extends Command
{
    /**
     * @var Publisher
     */
    private Publisher $publisher;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CLI Constructor
     *
     * @param \HarveyNorman\PromotionalProducts\Model\Backend\Publisher $publisher
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Publisher $publisher,
        LoggerInterface $logger
    ) {
        $this->publisher = $publisher;
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('promo:product:process')
            ->setDescription('Process Promotional Product Consumer');
        parent::configure();
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @TODO trigger Promotional Product Consumer */
        $output->writeln('<info>Promotional Products Updated successfully</info>');
        return Cli::RETURN_SUCCESS;
    }
}

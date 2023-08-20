<?php

namespace App\Command;

use App\Service\Logger\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeeLoggerInActionCommand extends Command
{
    protected string $name = 'logger:seeLoggerInAction';

    public function __construct(private LoggerInterface $logger) {
        parent::__construct($this->name);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->log('This is a debug message', LoggerInterface::LEVEL_DEBUG);
        $this->logger->log('---------------------------------------------', LoggerInterface::LEVEL_DEBUG);
        $this->logger->log('This is an info message', LoggerInterface::LEVEL_INFO);
        $this->logger->log('---------------------------------------------', LoggerInterface::LEVEL_INFO);
        $this->logger->log('This is a warning message', LoggerInterface::LEVEL_WARNING);
        $this->logger->log('---------------------------------------------', LoggerInterface::LEVEL_WARNING);
        $this->logger->log('This is an error message', LoggerInterface::LEVEL_ERROR);
        $this->logger->log('---------------------------------------------', LoggerInterface::LEVEL_ERROR);

        $this->logger->setLogLevelDuringRuntime(LoggerInterface::LEVEL_ERROR);
        $this->logger->log('You will not see this', LoggerInterface::LEVEL_WARNING);
        $this->logger->log('You will see this because is an error', LoggerInterface::LEVEL_ERROR);

        return self::SUCCESS;
    }
}

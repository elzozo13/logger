<?php

namespace App\Command;

use App\Service\Logger\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeeLoggerInActionCommand extends Command
{
    protected string $name = 'logger:seeLoggerInAction';

    public function __construct(private LoggerInterface $consoleLogger, private LoggerInterface $emailLogger) {
        parent::__construct($this->name);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->consoleLogger->log('This is a debug message', LoggerInterface::LEVEL_DEBUG);
        $this->consoleLogger->log('---------------------------------------------', LoggerInterface::LEVEL_DEBUG);
        $this->consoleLogger->log('This is an info message', LoggerInterface::LEVEL_INFO);
        $this->consoleLogger->log('---------------------------------------------', LoggerInterface::LEVEL_INFO);
        $this->consoleLogger->log('This is a warning message', LoggerInterface::LEVEL_WARNING);
        $this->consoleLogger->log('---------------------------------------------', LoggerInterface::LEVEL_WARNING);
        $this->consoleLogger->log('This is an error message', LoggerInterface::LEVEL_ERROR);
        $this->consoleLogger->log('---------------------------------------------', LoggerInterface::LEVEL_ERROR);

        $this->consoleLogger->setLogLevelDuringRuntime(LoggerInterface::LEVEL_ERROR);
        $this->consoleLogger->log('You will not see this', LoggerInterface::LEVEL_WARNING);
        $this->consoleLogger->log('You will see this because is an error', LoggerInterface::LEVEL_ERROR);

        $this->emailLogger->log('---------------------------------------------', LoggerInterface::LEVEL_ERROR);
        $this->emailLogger->log('This is a debug message', LoggerInterface::LEVEL_DEBUG);
        $this->emailLogger->log('---------------------------------------------', LoggerInterface::LEVEL_DEBUG);
        $this->emailLogger->log('This is an info message', LoggerInterface::LEVEL_INFO);
        $this->emailLogger->log('---------------------------------------------', LoggerInterface::LEVEL_INFO);
        $this->emailLogger->log('This is a warning message', LoggerInterface::LEVEL_WARNING);
        $this->emailLogger->log('---------------------------------------------', LoggerInterface::LEVEL_WARNING);
        $this->emailLogger->log('This is an error message', LoggerInterface::LEVEL_ERROR);
        $this->emailLogger->log('---------------------------------------------', LoggerInterface::LEVEL_ERROR);

        $this->emailLogger->setLogLevelDuringRuntime(LoggerInterface::LEVEL_ERROR);
        $this->emailLogger->log('You will not see this', LoggerInterface::LEVEL_WARNING);
        $this->emailLogger->log('You will see this because is an error', LoggerInterface::LEVEL_ERROR);


        return self::SUCCESS;
    }
}

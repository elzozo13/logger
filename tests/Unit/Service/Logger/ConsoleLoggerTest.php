<?php

namespace Unit\Service\Logger;

use App\Service\Logger\ConsoleLogger;
use App\Service\Logger\LoggerInterface;
use Codeception\Test\Unit;
use Exception;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConsoleLoggerTest extends Unit
{
    private OutputInterface $outputMock;

    private LoggerInterface $logger;

    /**
     * @throws Exception
     */
    protected function _before(): void
    {
        $this->outputMock = $this->makeEmpty(OutputInterface::class);
        $parameterBagMock = $this->makeEmpty(ParameterBagInterface::class, [
            'get' => LoggerInterface::LEVEL_INFO
        ]);

        $this->logger = new ConsoleLogger($parameterBagMock, $this->outputMock);
    }

    public function testDoesNotLogBelowLevel()
    {
        $this->outputMock->expects($this->never())->method('writeln');

        $this->logger->log('Debug message', LoggerInterface::LEVEL_DEBUG);
    }

    public function testLogsAboveLevel()
    {
        $this->outputMock->expects($this->once())->method('writeln');

        $this->logger->log('Error message', LoggerInterface::LEVEL_ERROR);
    }

    /**
     * @throws Exception
     */
    public function testMessageStyle()
    {
        $this->outputMock->expects($this->once())
            ->method('writeln')
            ->with($this->stringContains('<style>'));

        $formatterMock = $this->makeEmpty(OutputFormatterInterface::class);
        $this->outputMock->method('getFormatter')->willReturn($formatterMock);

        $this->logger->log('Info message', LoggerInterface::LEVEL_INFO);
    }
}

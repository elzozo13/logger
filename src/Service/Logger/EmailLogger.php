<?php

namespace App\Service\Logger;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EmailLogger extends AbstractLogger implements LoggerInterface
{
    protected string $logLevelParamName = 'log_level_email';

    public function __construct(ParameterBagInterface $parameterBag, protected OutputInterface $output) {
        // Instead of the OutputInterface we should autowire SymfonyMailer with the correct configs (is easy to do but the exercise specifically mentions not to do that)

        parent::__construct($parameterBag);
    }

    public function log(string $message, int $level): void
    {
        if ($level < $this->logLevel) {
            return;
        }

        $this->output->writeln('This is the email logger that actually outputs in console as requested: ' . $message);
    }
}

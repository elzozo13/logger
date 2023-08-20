<?php

namespace App\Service\Logger;

use LogicException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AbstractLogger
{
    protected int $logLevel;
    protected string $logLevelParamName = 'log_level';

    public function __construct(ParameterBagInterface $parameterBag) {
        /** @var String|Int $levelParam */
        $levelParam = $parameterBag->get($this->logLevelParamName);

        if ($levelParam > LoggerInterface::LEVEL_ERROR) {
            throw new LogicException('The logger level set is invalid');
        }

        $this->logLevel = (int) $levelParam;
    }

    public function setLogLevelDuringRuntime(int $level): static
    {
        if ($level > LoggerInterface::LEVEL_ERROR) {
            throw new LogicException('The logger level set is invalid');
        }

        $this->logLevel = $level;

        return $this;
    }
}
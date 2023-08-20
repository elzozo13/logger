<?php

namespace App\Service\Logger;

interface LoggerLevelSetterInterface
{
    public function setLogLevelDuringRuntime(int $level): static;
}
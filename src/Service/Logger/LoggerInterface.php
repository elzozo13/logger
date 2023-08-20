<?php

namespace App\Service\Logger;

interface LoggerInterface
{
    public const LEVEL_DEBUG = 0;
    public const LEVEL_INFO = 1;
    public const LEVEL_WARNING = 2;
    public const LEVEL_ERROR = 3;

    public const LEVELS_AS_STRING = [
        self::LEVEL_DEBUG => 'DEBUG',
        self::LEVEL_INFO => 'INFO',
        self::LEVEL_WARNING => 'WARNING',
        self::LEVEL_ERROR => 'ERROR',
    ];

    public function log(string $message, int $level): void;
    public function setLogLevelDuringRuntime(int $level): static;
}

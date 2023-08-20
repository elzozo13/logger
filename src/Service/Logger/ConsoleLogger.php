<?php

namespace App\Service\Logger;

use DateTimeImmutable;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ConsoleLogger implements LoggerInterface
{
    /** @var string[] */
    protected array $messageColorsByLevel = [
        self::LEVEL_DEBUG => '#cccccc',
        self::LEVEL_INFO => '#77ccff',
        self::LEVEL_WARNING => '#ffa701',
        self::LEVEL_ERROR => '#c30010',
    ];

    protected int $logLevel;

    private const STYLE = 'style';

    public function __construct(ParameterBagInterface $parameterBag, protected OutputInterface $output) {
        /** @var String|Int $levelParam */
        $levelParam = $parameterBag->get('log_level');
        $this->logLevel = (int) $levelParam;
    }

    public function log(string $message, int $level): void
    {
        if ($level < $this->logLevel) {
            return;
        }

        $displayMessage = $this->formatDisplayMessage($message, $level);
        $outputStyle = new OutputFormatterStyle($this->messageColorsByLevel[$level]);
        $this->output->getFormatter()->setStyle(self::STYLE, $outputStyle);
        $this->output->writeln($displayMessage);
    }

    public function setLogLevelDuringRuntime(int $level): static
    {
        $this->logLevel = $level;

        return $this;
    }

    protected function formatDisplayMessage(string $message, int $level): string
    {
        $currentTime = new DateTimeImmutable();

        return '<' . self::STYLE . '>' .
            $currentTime->format('Y-m-d H:i:s.u') .
            ' ' .
            $this->padLevelToHaveSameLength(self::LEVELS_AS_STRING[$level]) .
            ': ' .
            $message .
            '</>'
        ;
    }

    protected function padLevelToHaveSameLength(string $level): string
    {
        $maxLength = 0;
        foreach (self::LEVELS_AS_STRING as $definedLevel) {
            $length = strlen($definedLevel);
            if ($length > $maxLength) {
                $maxLength = $length;
            }
        }

        $padSize = $maxLength - strlen($level) + 1;
        $level .= str_repeat(' ', $padSize);

        return $level;
    }
}

<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\FormattedPsrHandler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

use function strtolower;
use function WyriHaximus\PSR3\formatValue;

final class FormattedPsrHandler extends AbstractProcessingHandler
{
    protected LoggerInterface $logger;

    /**
     * @phpstan-ignore-next-line
     */
    public function __construct(LoggerInterface $logger, int|string $level = Logger::DEBUG, bool $bubble = true)
    {
        /**
         * @psalm-suppress ArgumentTypeCoercion
         */
        parent::__construct($level, $bubble);

        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function write(array $record): void
    {
        if (! $this->isHandling($record)) {
            return;
        }

        $this->logger->log(
            strtolower($record['level_name']),
            formatValue($record['formatted'] ?? $record['message']),
            $record['context']
        );
    }
}

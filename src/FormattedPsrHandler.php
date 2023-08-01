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
    /** @phpstan-ignore-next-line */
    public function __construct(protected LoggerInterface $logger, int|string $level = Logger::DEBUG, bool $bubble = true)
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record): void
    {
        /** @psalm-suppress InvalidArgument */
        if (! $this->isHandling($record)) {
            // @codeCoverageIgnoreStart
            return; // This is tested in FormattedPsrHandlerTest::notHandled but not picked up by PHPUnit as covered

            // @codeCoverageIgnoreEnd
        }

        $this->logger->log(
            strtolower($record['level_name']),
            formatValue($record['formatted'] ?? $record['message']),
            $record['context'],
        );
    }
}

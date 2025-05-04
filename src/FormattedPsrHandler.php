<?php

declare(strict_types=1);

namespace WyriHaximus\Monolog\FormattedPsrHandler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Psr\Log\LoggerInterface;
use WyriHaximus\PSR3\Utils;

use function strtolower;

final class FormattedPsrHandler extends AbstractProcessingHandler
{
    /** @phpstan-ignore-next-line */
    public function __construct(protected LoggerInterface $logger, int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        /** @psalm-suppress InvalidArgument */
        if (! $this->isHandling($record)) {
            // @codeCoverageIgnoreStart
            return; // This is tested in FormattedPsrHandlerTest::notHandled but not picked up by PHPUnit as covered

            // @codeCoverageIgnoreEnd
        }

        $this->logger->log(
            strtolower($record->level->name),
            Utils::formatValue($record->formatted ?? $record->message),
            $record->context,
        );
    }
}

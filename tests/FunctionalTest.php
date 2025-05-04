<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\FormattedPsrHandler;

use Monolog\Logger;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\AbstractLogger;
use WyriHaximus\Monolog\FormattedPsrHandler\FormattedPsrHandler;
use WyriHaximus\TestUtilities\TestCase;

final class FunctionalTest extends TestCase
{
    /** @var array<array{context: array<mixed>, level: string, message: string}> */
    private array $logs = [];

    #[Test]
    public function basic(): void
    {
        $monolog = $this->provideMonolog();

        $monolog->info('message');

        self::assertStringContainsString("] logger.INFO: message [] []\n", $this->logs[0]['message']);

        $logs = $this->logs;
        unset($logs[0]['message']);
        self::assertSame([
            [
                'level' => 'info',
                'context' => [],
            ],
        ], $logs);
    }

    private function provideMonolog(): Logger
    {
        $monolog = new Logger('logger');

        /** @param array{context: array<mixed>, level: string, message: string} $log */
        $handler = function (array $log): void {
            $this->logs[] = $log;
        };

        $monolog->pushHandler(new FormattedPsrHandler(new class ($handler) extends AbstractLogger {
            /** @var callable */
            private $handler;

            public function __construct(callable $handler)
            {
                $this->handler = $handler;
            }

            /**
             * @param array<string, mixed> $context
             *
             * @inheritDoc
             */
            public function log($level, $message, array $context = []): void
            {
                ($this->handler)([
                    'level' => $level,
                    'message' => $message,
                    'context' => $context,
                ]);
            }
        }));

        return $monolog;
    }
}

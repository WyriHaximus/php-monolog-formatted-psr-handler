<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\FormattedPsrHandler;

use Monolog\Logger;
use Psr\Log\AbstractLogger;
use WyriHaximus\Monolog\FormattedPsrHandler\FormattedPsrHandler;
use WyriHaximus\TestUtilities\TestCase;

/** @internal */
final class FunctionalTest extends TestCase
{
    /** @var array<array<mixed>> */
    private array $logs = [];

    /** @test */
    public function basic(): void
    {
        $monolog = $this->provideMonolog();

        $monolog->info('message');

        self::assertArrayHasKey('message', $this->logs[0]);
        self::assertStringContainsString("] logger.INFO: message [] []\n", $this->logs[0]['message']);
        unset($this->logs[0]['message']);

        self::assertSame([
            [
                'level' => 'info',
                'context' => [],
            ],
        ], $this->logs);
    }

    private function provideMonolog(): Logger
    {
        $monolog = new Logger('logger');

        $monolog->pushHandler(new FormattedPsrHandler(new class (function ($log): void {
            $this->logs[] = $log;
        }) extends AbstractLogger {
            /** @var callable */
            private $handler;

            public function __construct(callable $handler)
            {
                $this->handler = $handler;
            }

            /**
             * @phpstan-ignore-next-line
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

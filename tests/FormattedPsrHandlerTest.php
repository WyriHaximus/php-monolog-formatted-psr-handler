<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\FormattedPsrHandler;

use DateTimeInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Safe\DateTimeImmutable;
use WyriHaximus\Monolog\FormattedPsrHandler\FormattedPsrHandler;
use WyriHaximus\TestUtilities\TestCase;

use const PHP_EOL;

/**
 * @internal
 */
final class FormattedPsrHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function formatted(): void
    {
        $now     = new DateTimeImmutable('now');
        $record  = [
            'channel' => 'formatted-psr-handler',
            'datetime' => $now,
            'level' => Logger::DEBUG,
            'level_name' => 'DEBUG',
            'message' => 'message',
            'context' => [],
            'extra' => [],
        ];
        $message = '[' . $now->format(DateTimeInterface::ATOM) . '] formatted-psr-handler.DEBUG: message [] []' . PHP_EOL;
        $logger  = $this->prophesize(LoggerInterface::class);
        $logger->log('debug', $message, [])->shouldBeCalled();

        $formattedLogger = new FormattedPsrHandler($logger->reveal());
        $formattedLogger->handle($record);
    }
}

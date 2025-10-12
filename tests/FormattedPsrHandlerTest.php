<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\FormattedPsrHandler;

use DateTimeInterface;
use Mockery;
use Monolog\Level;
use Monolog\LogRecord;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use Safe\DateTimeImmutable;
use WyriHaximus\Monolog\FormattedPsrHandler\FormattedPsrHandler;
use WyriHaximus\TestUtilities\TestCase;

final class FormattedPsrHandlerTest extends TestCase
{
    #[Test]
    public function formatted(): void
    {
        $now     = new DateTimeImmutable('now');
        $record  = new LogRecord(
            datetime: $now,
            channel: 'formatted-psr-handler',
            level: Level::Debug,
            message: 'message',
            context: [],
            extra: [],
        );
        $message = '[' . $now->format(DateTimeInterface::ATOM) . '] formatted-psr-handler.DEBUG: message [] []' . "\n";
        $logger  = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with('debug', $message, [])->atLeast()->once();

        $formattedLogger = new FormattedPsrHandler($logger);
        $formattedLogger->handle($record);
    }

    #[Test]
    public function notHandled(): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with(Mockery::type('string'), Mockery::type('array'), Mockery::type('array'))->never();

        $formattedLogger = new FormattedPsrHandler($logger, Level::Emergency->value);
        $formattedLogger->handle(new LogRecord(
            datetime: new DateTimeImmutable('now'),
            channel: 'formatted-psr-handler',
            level: Level::Debug,
            message: 'message',
            context: [],
            extra: [],
        ));
    }

    #[Test]
    public function bubble(): void
    {
        $formattedLogger = new FormattedPsrHandler(Mockery::mock(LoggerInterface::class), Level::Emergency->value);
        self::assertTrue($formattedLogger->getBubble());
    }
}

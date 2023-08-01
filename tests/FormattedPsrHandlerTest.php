<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\FormattedPsrHandler;

use DateTimeInterface;
use Monolog\Level;
use Monolog\LogRecord;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Safe\DateTimeImmutable;
use WyriHaximus\Monolog\FormattedPsrHandler\FormattedPsrHandler;
use WyriHaximus\TestUtilities\TestCase;

/** @internal */
final class FormattedPsrHandlerTest extends TestCase
{
    /** @test */
    public function formatted(): void
    {
        $now     = new DateTimeImmutable('now');
        $record  = new LogRecord(
            channel: 'formatted-psr-handler',
            datetime: $now,
            level: Level::Debug,
            message: 'message',
            context: [],
            extra: [],
        );
        $message = '[' . $now->format(DateTimeInterface::ATOM) . '] formatted-psr-handler.DEBUG: message [] []' . "\n";
        $logger  = $this->prophesize(LoggerInterface::class);
        $logger->log('debug', $message, [])->shouldBeCalled();

        $formattedLogger = new FormattedPsrHandler($logger->reveal());
        $formattedLogger->handle($record);
    }

    /** @test */
    public function notHandled(): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log(Argument::type('string'), Argument::type('array'), Argument::type('array'))->shouldNotBeCalled();

        $formattedLogger = new FormattedPsrHandler($logger->reveal(), Level::Emergency->value);
        $formattedLogger->handle(new LogRecord(
            channel: 'formatted-psr-handler',
            datetime: new DateTimeImmutable('now'),
            level: Level::Debug,
            message: 'message',
            context: [],
            extra: [],
        ));
    }

    /** @test */
    public function bubble(): void
    {
        $formattedLogger = new FormattedPsrHandler($this->prophesize(LoggerInterface::class)->reveal(), Level::Emergency->value);
        self::assertTrue($formattedLogger->getBubble());
    }
}

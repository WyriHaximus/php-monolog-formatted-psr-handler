<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\Monolog\FormattedPsrHandler;

use DateTimeInterface;
use Monolog\Logger;
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
        $record  = [
            'channel' => 'formatted-psr-handler',
            'datetime' => $now,
            'level' => Logger::DEBUG,
            'level_name' => 'DEBUG',
            'message' => 'message',
            'context' => [],
            'extra' => [],
        ];
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

        $formattedLogger = new FormattedPsrHandler($logger->reveal(), Logger::EMERGENCY);
        $formattedLogger->handle([
            'channel' => 'formatted-psr-handler',
            'datetime' => new DateTimeImmutable('now'),
            'level' => Logger::DEBUG,
            'level_name' => 'DEBUG',
            'message' => 'message',
            'context' => [],
            'extra' => [],
        ]);
    }

    /** @test */
    public function bubble(): void
    {
        $formattedLogger = new FormattedPsrHandler($this->prophesize(LoggerInterface::class)->reveal(), Logger::EMERGENCY);
        self::assertTrue($formattedLogger->getBubble());
    }
}

<?php

namespace WyriHaximus\Tests\Monolog\FormattedPsrHandler;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use WyriHaximus\Monolog\FormattedPsrHandler\FormattedPsrHandler;

final class FormattedPsrHandlerTest extends TestCase
{
    public function provideRecords()
    {
        yield [
            [
                'level' => Logger::DEBUG,
                'level_name' => 'debug',
                'message' => 'message',
                'context' => [],
            ],
            'message',
        ];

        yield [
            [
                'level' => Logger::DEBUG,
                'level_name' => 'debug',
                'formatted' => '<h1>message</h1>',
                'message' => 'message',
                'context' => [],
            ],
            '<h1>message</h1>',
        ];
    }

    /**
     * @dataProvider provideRecords
     */
    public function testFiltered(array $record, string $message)
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log('debug', $message, [])->shouldBeCalled();

        $formattedLogger = new FormattedPsrHandler($logger->reveal());
        $formattedLogger->handle($record);
    }
}

<?php declare(strict_types=1);

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
                'channel' => 'formatted-psr-handler',
                'datetime' => 'now',
                'level' => Logger::DEBUG,
                'level_name' => 'debug',
                'message' => 'message',
                'context' => [],
                'extra' => [],
            ],
            '[now] formatted-psr-handler.debug: message [] []' . PHP_EOL,
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

<?php

namespace WyriHaximus\Monolog\FormattedPsrHandler;

use Monolog\Handler\AbstractHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class FormattedPsrHandler extends AbstractHandler
{
    protected $logger;

    public function __construct(LoggerInterface $logger, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(array $record)
    {
        if (!$this->isHandling($record)) {
            return false;
        }

        $this->logger->log(
            strtolower($record['level_name']),
            $record['formatted'] ?? $record['message'],
            $record['context']
        );

        return false === $this->bubble;
    }
}

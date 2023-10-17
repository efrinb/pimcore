<?php
namespace App\Service;

use Psr\Log\LoggerInterface;

class CustomService
{
    private LoggerInterface $customLog;

    public function __construct(LoggerInterface $customLog)
    {
        $this->customLog = $customLog;
    }

    public function customLogger(): void
    {
        $this->customLog->debug('Test Message');
    }
}

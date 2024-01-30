<?php

namespace Core;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    private string $textFormat = "[%channel%] [%level_name%] [%datetime%]: %message% %context% %extra% \n";
    private string $dateFormat = "Y-m-d H:i:s";
    private string $logConsole = 'php://stdout';
    private string $logFile = 'logs/app.log';
    private bool $isLogToConsole = true;
    private bool $isLogToFile = true;

    public function getLogger($loggerName): LoggerInterface
    {
        $logger = new Logger($loggerName);

        assert($this->isLogToConsole || $this->isLogToFile, 'No logging stream has been selected.');

        if ($this->isLogToConsole) {
            $consoleHandler = new StreamHandler($this->logConsole, Level::Debug);
            $consoleHandler->setFormatter(new LineFormatter($this->textFormat, $this->dateFormat));
            $logger->pushHandler($consoleHandler);
        }

        if ($this->isLogToFile) {
            $fileHandler = new RotatingFileHandler($this->logFile, 7, Level::Debug);
            $fileHandler->setFormatter(new LineFormatter($this->textFormat, $this->dateFormat));
            $logger->pushHandler($fileHandler);
        }

        return $logger;
    }

    public function setLogToConsole(bool $isLogToConsole): void
    {
        $this->isLogToConsole = $isLogToConsole;
    }

    public function setLogToFile(bool $isLogToFile): void
    {
        $this->isLogToFile = $isLogToFile;
    }
}
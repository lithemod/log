<?php

namespace Tests\Support;

use Lithe\Support\Log;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class LogTest extends TestCase
{
    protected function setUp(): void
    {
        // Set a temporary directory for testing logs
        Log::dir(__DIR__ . '/../storage/logs');
        
        // Ensure the logs directory is clean before each test
        $this->cleanLogs();
    }

    protected function tearDown(): void
    {
        // Clean up after tests
        $this->cleanLogs();
    }

    private function cleanLogs()
    {
        $logDir = __DIR__ . '/../storage/logs';
        array_map('unlink', glob("$logDir/*.*")); // Remove all log files
        rmdir($logDir); // Remove the log directory
    }

    public function testLogInfo()
    {
        Log::info('This is an info message.');

        $this->assertFileExists(__DIR__ . '/../storage/logs/info.log');
        $this->assertStringContainsString('INFO: This is an info message.', file_get_contents(__DIR__ . '/../storage/logs/info.log'));
    }

    public function testLogWarning()
    {
        Log::warning('This is a warning message.');

        $this->assertFileExists(__DIR__ . '/../storage/logs/warning.log');
        $this->assertStringContainsString('WARNING: This is a warning message.', file_get_contents(__DIR__ . '/../storage/logs/warning.log'));
    }

    public function testLogError()
    {
        Log::error('This is an error message.');

        $this->assertFileExists(__DIR__ . '/../storage/logs/error.log');
        $this->assertStringContainsString('ERROR: This is an error message.', file_get_contents(__DIR__ . '/../storage/logs/error.log'));
    }

    public function testInvalidLogLevel()
    {
        $this->expectException(RuntimeException::class);
        Log::info('This is an info message.'); // Valid log

        // Attempt to log with an invalid level (not directly possible, 
        // need to modify the class to make it testable if this is desired)
        Log::dir(__DIR__ . '/../storage/logs');
        $reflection = new \ReflectionClass(Log::class);
        $method = $reflection->getMethod('log');
        $method->setAccessible(true);
        $method->invokeArgs(null, ['invalid', 'This should throw an exception']);
    }

    public function testLogDirectoryCreation()
    {
        // Testing if directory creation works
        Log::dir(__DIR__ . '/../non_existent_directory/storage/logs');
        Log::info('Testing log directory creation.');

        $this->assertFileExists(__DIR__ . '/../non_existent_directory/storage/logs/info.log');
    }
}

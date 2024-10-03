<?php

namespace Lithe\Support;

use RuntimeException;

class Log
{
    /**
     * Directory where logs will be stored.
     *
     * @var string|null
     */
    private static $logDir;

    /**
     * Allowed log levels.
     */
    const LOG_LEVELS = ['info', 'warning', 'error'];

    /**
     * Sets the base directory where logs will be stored.
     *
     * This method must be called before any logging occurs. 
     * If the directory does not exist, it will be created.
     *
     * @param string $dir The base directory for storing logs. It should be an absolute path.
     *
     * @throws RuntimeException If the directory cannot be created.
     */
    public static function dir(string $dir): void
    {
        self::$logDir = rtrim($dir, '/'); // Remove trailing slash, if it exists
    }

    /**
     * Ensures that the log directory exists. If it does not exist, 
     * an attempt will be made to create it.
     *
     * @throws RuntimeException If the directory cannot be created.
     */
    private static function ensureLogDirExists()
    {
        if (!self::$logDir) {
            // Set a default log directory if none has been provided
            self::$logDir = dirname(__DIR__, 4) . '/storage/logs'; // Default to a 'logs' directory two levels up
        }

        if (!is_dir(self::$logDir)) {
            if (!mkdir(self::$logDir, 0777, true) && !is_dir(self::$logDir)) {
                throw new RuntimeException("Failed to create log directory: " . self::$logDir);
            }
        }
    }

    /**
     * Logs a message to the specified log file based on the log level.
     *
     * @param string $level The log level (info, warning, error).
     * 
     * @param string $message The message to log.
     * 
     * @throws RuntimeException If the log level is invalid.
     */
    private static function log(string $level, string $message): void
    {
        if (!in_array($level, self::LOG_LEVELS)) {
            throw new RuntimeException("Invalid log level: $level");
        }

        // Ensure the log directory exists
        self::ensureLogDirExists();

        // Path to the log file
        $logFile = self::$logDir . "/$level.log";

        // Get the current time
        $currentTime = date('Y-m-d H:i:s');

        // Format the log message
        $logMessage = "[{$currentTime}] " . strtoupper($level) . ": {$message}\n";

        // Append the log message to the log file
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    /**
     * Logs an informational message.
     *
     * @param string $message The message to log.
     */
    public static function info(string $message): void
    {
        self::log('info', $message);
    }

    /**
     * Logs a warning message.
     *
     * @param string $message The message to log.
     */
    public static function warning(string $message): void
    {
        self::log('warning', $message);
    }

    /**
     * Logs an error message.
     *
     * @param string $message The message to log.
     */
    public static function error(string $message): void
    {
        self::log('error', $message);
    }
}

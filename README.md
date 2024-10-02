# Lithe Log

A simple logging library for PHP applications. This package provides an easy way to log messages with different severity levels (info, warning, error) into log files.

## Installation

You can install this package via Composer. Run the following command in your terminal:

```bash
composer require lithemod/log
```

### Alternative Installation

If you want to install it directly from the source without using Composer, you can download the source code and place it in your project. Ensure to set the log directory manually using the `Log::dir()` method.

## Usage

To use the logging functionality, follow these simple steps:

1. **Set the Log Directory**: Before logging any messages, set the directory where the logs should be stored.

```php
<?php

require 'vendor/autoload.php'; // If using Composer

use Lithe\Support\Log;

// Set the log directory
Log::dir(__DIR__ . '/logs'); // Specify your desired log directory
```

2. **Log Messages**: You can log messages with different severity levels using the following methods:

```php
// Log an informational message
Log::info('This is an informational message.');

// Log a warning message
Log::warning('This is a warning message.');

// Log an error message
Log::error('This is an error message.');
```

3. **Check the Logs**: After logging messages, check the specified log directory for the log files. You will find separate files for each log level (`info.log`, `warning.log`, `error.log`).

## Example

Here’s a complete example:

```php
<?php

require 'vendor/autoload.php'; // Include Composer's autoload file

use Lithe\Support\Log;

// Set the log directory
Log::dir(__DIR__ . '/logs');

// Log messages
Log::info('Application started.');
Log::warning('This is a warning.');
Log::error('An error occurred.');
```

## Contributing

If you wish to contribute to this project, feel free to fork the repository and submit a pull request. Contributions are always welcome!

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
<?php namespace YesTracy;

use Tracy\Debugger as BaseDebugger;

class Debugger extends BaseDebugger
{
    public static function enable($mode = null, string $logDirectory = null, $email = null): void
    {
        parent::enable($mode, $logDirectory, $email);

        set_error_handler([__CLASS__, 'errorHandler']);
    }

    public static function errorHandler(int $severity, string $message, string $file, int $line, ?array $context = []): ?bool
    {
        return parent::errorHandler($severity, $message, $file, $line, $context);
    }
}

<?php

declare(strict_types = 1);

namespace classes\Helpers;

/**
 * Класс хелпер для логирования
 */
Class LogHelper
{
    /**
     * Статичный метод логирования в файл
     *
     * @param string $message
     * @param string $file
     * @return bool
     */
    public static function logToFile(string $message, $file = 'log.txt'): bool
    {
        $filePath = __DIR__ . '/' . $file;
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message" . PHP_EOL;
        
        return (file_put_contents($filePath, $logMessage, FILE_APPEND) !== false);
    }
}

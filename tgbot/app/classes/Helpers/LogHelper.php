<?php

declare(strict_types=1);

namespace classes\Helpers;

/**
 * Класс хелпер для логирования
 */
Class LogHelper
{
    /**
     * Статичный метод логирования строки в файл
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
    
    /**
     * Статичный метод логирования декодированного json в файл
     *
     * @param array $json
     * @param string $file
     * @return boolean
     */
    public static function arrLogToFile(array $json, $file = 'arr_log.txt'): bool
    {
        $filePath = __DIR__ . '/' . $file;
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] " . print_r($json, true) . PHP_EOL;
        
        return (file_put_contents($filePath, $logMessage, FILE_APPEND) !== false);
    }
}

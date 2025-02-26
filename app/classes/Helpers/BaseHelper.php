<?php

declare(strict_types = 1);

namespace classes\Helpers;

/**
 * Класс помощник для разгрузки основных классов
 */
Class BaseHelper
{
    /**
     * Статичный паблик метод для выполнения курл запросов
     *
     * @param string $url
     * @return array
     */
    public static function curlHelper(string $url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            LogHelper::logToFile('cURL error: ' . curl_error($ch));
            return ['error' => 'cURL error: ' . curl_error($ch)];
        }
        curl_close($ch);
        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            LogHelper::logToFile('JSON decode error: ' . json_last_error_msg());
            return ['error' => 'JSON decode error: ' . json_last_error_msg()];
        }

        return $decodedResponse;
    }
}

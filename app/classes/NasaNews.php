<?php

declare(strict_types = 1);

namespace classes;

use classes\LogHelper;
use Longman\TelegramBot\Request;

/**
 * Класс взаиомдействия с NASA API
 */
class NasaNews
{
    /**
     * Ключ для NASA API
     *
     * @var string
     */
    private string $api;

    /**
     * Конструктор с инициализацией API KEY
     */
    public function __construct()
    {
        $this->api = getenv('NASA_API_KEY');
    }

    /**
     * Паблик метод получения ответа на запрос астрофотографии дня
     *
     * @return array
     */
    public function getAPOD(): array
    {
        $url = 'https://api.nasa.gov/planetary/apod?api_key=' . $this->api;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            LogHelper::logToFile('cURL error: ' . curl_error($ch));
            return [];
        }
        curl_close($ch);
        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            LogHelper::logToFile('JSON decode error: ' . json_last_error_msg());
            return [];
        }
        return $decodedResponse;
    }
}

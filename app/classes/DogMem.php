<?php

declare(strict_types = 1);

namespace classes;

use Longman\TelegramBot\Request;
use classes\ButtonRender;
use classes\LogHelper;

/**
 * Класс с одним статичным методом
 */
Class DogMem
{
    /**
     * Хранение адреса, API ключ не нужен
     *
     * @var string
     */
    private static string $memUrl = 'https://random.dog/woof.json';

    /**
     * Статичный метод отправки фото с собачкой))
     *
     * @param integer $chatID
     * @return void
     */
    public static function sendDogMem(int $chatID): void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$memUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            LogHelper::logToFile('cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            LogHelper::logToFile('JSON decode error: ' . json_last_error_msg());
        }

        $photoUrl = $decodedResponse['url'];
        Request::sendPhoto([
            'chat_id' => $chatID,
            'photo' => $photoUrl,
            'reply_markup' => ButtonRender::dogKeyboard(),
        ]);
    }
}

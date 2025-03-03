<?php

declare(strict_types=1);

namespace classes;

use Longman\TelegramBot\Request;
use classes\ButtonRender;
use classes\Helpers\LogHelper;
use classes\Helpers\BaseHelper;

/**
 * Класс с одним статичным методом
 */
Class DogMem
{
    /**
     * Хранение адреса, API ключ не нужен, так что запрос выполняется без него
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
        $decodedResponse = BaseHelper::curlHelper(self::$memUrl);
        $photoUrl = $decodedResponse['url'];
        $response = Request::sendPhoto([
            'chat_id' => $chatID,
            'photo' => $photoUrl,
            'reply_markup' => ButtonRender::getMemKeyboard(),
        ]);
        if (!$response->isOk()) {
            LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
        } else {
            BaseHelper::sendErrorMessage($chatID);
        }
    }
}

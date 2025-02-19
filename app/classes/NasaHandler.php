<?php

declare(strict_types = 1);

namespace classes;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\CallbackQuery;
use classes\LogHelper;
use classes\ButtonRender;
use classes\NasaNews;
use classes\Translator;

/**
 * Класс со статичными методами для бработки callback запросов с NASA
 */
class NasaHandler
{
    /**
     * Статичный паблик метод для ответа на первичный callback запрос с NASA
     *
     * @param integer $chatID
     * @return void
     */
    public static function startNasaHandler(int $chatID): void
    {
        Request::sendMessage([
            'chat_id' => $chatID,
            'text'    => 'Функция находится в разработке, пока только фото дня от NASA без перевода.',
            'reply_markup' => ButtonRender::nasaNewsKeyboard()
        ]);
    }

    /**
     * Статичный паблик метод для отправки астрофотографии дня
     *
     * @param integer $chatID
     * @return void
     */
    public static function sendAPOD(int $chatID): void
    {
        $explanation = '';
        $nasaNews = new NasaNews();
        $response = $nasaNews->getAPOD();
        $explanation .= 'Название фотографии: ' . $response['title'] . PHP_EOL;
        if ($response['copyrighy']) {
            $explanation .= 'Авторы: ' . $response['copyright'] . PHP_EOL;
        }        
        // $test = Translator::translate($response['title']);
        Request::sendPhoto([
            'chat_id' => $chatID,
            'photo' => $response['url'],
            'caption' => $explanation,
        ]);
    }
}

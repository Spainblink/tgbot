<?php

declare(strict_types = 1);

namespace classes;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\CallbackQuery;
use classes\Helpers\LogHelper;
use classes\Helpers\BaseHelper;
use classes\ButtonRender;
use classes\Translator;

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
     * Статичный паблик метод для ответа на первичный callback запрос с NASA
     *
     * @param integer $chatID
     * @return void
     */
    public function startNasaHandler(int $chatID): void
    {
        Request::sendMessage([
            'chat_id' => $chatID,
            'text'    => 'Функция находится в разработке, пока только фото дня от NASA без перевода.',
            'reply_markup' => ButtonRender::nasaNewsKeyboard()
        ]);
    }

    /**
     * Паблик метод для отправки астрофотографии дня
     *
     * @param integer $chatID
     * @return void
     */
    public function sendAPOD(int $chatID): void
    {
        $explanation = '';
        $url = 'https://api.nasa.gov/planetary/apod?api_key=' . $this->api;        
        $response = BaseHelper::curlHelper($url);
        $explanation .= 'Название фотографии: ' . $response['title'] . PHP_EOL;
        if ($response['copyrighy']) {
            $explanation .= 'Авторы: ' . $response['copyright'] . PHP_EOL;
        }        
        // $test = Translator::translate($response['title']);
        Request::sendPhoto([
            'chat_id' => $chatID,
            'photo' => $response['url'],
            'caption' => $explanation,
            'reply_markup' => ButtonRender::nasaNewsKeyboard()
        ]);
    }
}

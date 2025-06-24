<?php

declare(strict_types=1);

namespace classes;

use Longman\TelegramBot\Request;
use classes\Helpers\LogHelper;
use classes\Helpers\BaseHelper;
use classes\ButtonRender;

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
     * Паблик метод для первичной обработки запроса с NASA
     *
     * @param integer $chatID
     * @return void
     */
    public function startNasaHandler(int $chatID): void
    {
        $response = Request::sendMessage([
            'chat_id' => $chatID,
            'text'    => 'Данная функция находится в разработке, еще нет перевода и соответственно новостей, только астрофотография дня, которая обновляется по восточному времени США. Это 7:00 по московскому времени.',
            'reply_markup' => ButtonRender::nasaNewsKeyboard()
        ]);
        if (!$response->isOk()) {
            LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
            BaseHelper::sendErrorMessage($chatID);
        }
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
        if ($response['copyright']) {
            $explanation .= 'Авторы: ' . $response['copyright'] . PHP_EOL;
        }
        // $test = Translator::translate($response['title']);
        $tgResponse = Request::sendPhoto([
            'chat_id' => $chatID,
            'photo' => $response['url'],
            'caption' => $explanation,
            'reply_markup' => ButtonRender::nasaNewsKeyboard()
        ]);
        // Добавил обработку ссылок с ютуба, НАСА иногда их присылает, а иногда рандомно генерит текст -_-
        if (!$tgResponse->isOk()) {
            if ($response['media_type'] == 'video') {
                $tgResponse = Request::sendMessage([
                    'chat_id' => $chatID,
                    'text' => 'NASA, почему-то вместо астрофотографии дня, выбрал астровидео дня.' . PHP_EOL . 'Название: ' . $response['title'] . PHP_EOL . $response['url']
                ]);
                if (!$tgResponse->isOk()) {
                    LogHelper::logToFile('Ошибка отправки второго сообщения: ' . $tgResponse->getDescription());
                    LogHelper::arrLogToFile($response);
                    BaseHelper::sendErrorMessage($chatID);
                }
            } else {
                LogHelper::logToFile('Ошибка отправки сообщения: ' . $tgResponse->getDescription());
                LogHelper::arrLogToFile($response);
                BaseHelper::sendErrorMessage($chatID);
            }
        }
    }
}

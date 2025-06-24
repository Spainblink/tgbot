<?php

declare(strict_types=1);

namespace classes;

use Longman\TelegramBot\Request;
use classes\ButtonRender;
use classes\Helpers\LogHelper;
use classes\Helpers\BaseHelper;

/**
 * Класс доступа к API giphy.com с методами получения gif изображений
 */
Class Giphy
{
    /**
     * API key для giphy
     *
     * @var string
     */
    private string $giphyAPI;

    /**
     * url для giphy
     *
     * @var string
     */
    private string $giphyUrl;

    /**
     * Конструктор с определением необходимых зависимостей для доступа к API Giphy
     */
    public function __construct()
    {
        $this->giphyAPI = getenv('GIPHY_API_KEY');
        $this->giphyUrl = 'https://api.giphy.com/v1/gifs/random?api_key=';
    }

    /**
     * Паблик метод для первичной обработки запроса мемов
     *
     * @param integer $chatID
     * @return void
     */
    public function startMemHandler(int $chatID): void
    {
        $response = Request::sendMessage([
            'chat_id' => $chatID,
            'text'    => 'Выбери что тебе интересно, функция находится в разработке, возможно скоро все поменяется или вообще пропадет.',
            'reply_markup' => ButtonRender::getMemKeyboard()
        ]);
        if (!$response->isOk()) {
            LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
            BaseHelper::sendErrorMessage($chatID);
        }
    }
    /**
     * Метод отправки рандомного gif с котиками
     *
     * @param integer $chatID
     * @return void
     */
    public function sendCatGif(int $chatID): void
    {
        $url = $this->giphyUrl . $this->giphyAPI . '&tag=cat';
        $decodedResponse = BaseHelper::curlHelper($url);
        $gifUrl = $decodedResponse['data']['images']['original']['url'];
        $response = Request::sendAnimation([
            'chat_id' => $chatID,
            'animation' => $gifUrl,
            'reply_markup' => ButtonRender::getMemKeyboard()
        ]);
        if (!$response->isOk()) {
            LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
            BaseHelper::sendErrorMessage($chatID);
        }
    }

    /**
     * Метод отправки рандомного gif с собачками
     *
     * @param integer $chatID
     * @return void
     */
    public function sendDogGif(int $chatID): void
    {
        $url = $this->giphyUrl . $this->giphyAPI . '&tag=dog';   
        $decodedResponse = BaseHelper::curlHelper($url);
        $gifUrl = $decodedResponse['data']['images']['original']['url'];
        $response = Request::sendAnimation([
            'chat_id' => $chatID,
            'animation' => $gifUrl,
            'reply_markup' => ButtonRender::getMemKeyboard()
        ]);
        if (!$response->isOk()) {
            LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
            BaseHelper::sendErrorMessage($chatID);
        }
    }

    /**
     * Метод отправки рандомной gif
     *
     * @param integer $chatID
     * @return void
     */
    public function sendRandGif(int $chatID): void
    {
        $url = $this->giphyUrl . $this->giphyAPI;
        $decodedResponse = BaseHelper::curlHelper($url);
        $gifUrl = $decodedResponse['data']['images']['original']['url'];
        $response = Request::sendAnimation([
            'chat_id' => $chatID,
            'animation' => $gifUrl,
            'reply_markup' => ButtonRender::getMemKeyboard()
        ]);
        if (!$response->isOk()) {
            LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
            BaseHelper::sendErrorMessage($chatID);
        }
    }
}

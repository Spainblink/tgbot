<?php

declare(strict_types=1);

namespace classes\Handlers;

use classes\Helpers\LogHelper;
use classes\Helpers\BaseHelper;
use classes\NasaNews;
use classes\ButtonRender;
use classes\DogMem;
use classes\Giphy;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\CallbackQuery;

/**
 * Класс обработчик всех callback запросов
 */
Class CallbackHandler
{

/**
     * Входящий колбэк
     *
     * @var CallbackQuery
     */
    private CallbackQuery $callbackQuery;

    /**
     * Хранение id часа для удобства
     *
     * @var integer
     */
    private int $chatID;

    /**
     * Конструктор класса обработки callback запросов
     *
     * @param CallbackQuery $callback
     */
    public function __construct(CallbackQuery $callback)
    {
        $this->callbackQuery = $callback;
        $this->chatID = $this->callbackQuery->getMessage()->getChat()->getId();
        $this->callbackHandler();
    }

    /**
     * Приватный метод - главный обработчик callback запросов, определяет запрос
     * и возвращает ответ
     *
     * @return void
     */
    private function callbackHandler(): void
    {
        $callbackData = $this->callbackQuery->getData();
        switch ($callbackData) {
            case 'APOD':
                $nasa = new NasaNews();
                $nasa->sendAPOD($this->chatID);
            break;

            case 'getDog':
                DogMem::sendDogMem($this->chatID);
            break;

            case 'getCatGif':
                $catGif = new Giphy();
                $catGif->sendCatGif($this->chatID);
            break;

            case 'getDogGif':
                $dogGif = new Giphy();
                $dogGif->sendDogGif($this->chatID);
            break;

            case 'getRandGif':
                $randGif = new Giphy();
                $randGif->sendRandGif($this->chatID);
            break;
        }
    }
}

<?php

declare(strict_types=1);

namespace classes\Handlers;

use classes\NasaNews;
use classes\DogMem;
use classes\Giphy;
use Longman\TelegramBot\Entities\CallbackQuery;

/**
 * Класс обработчик всех callback запросов
 */
Class CallbackHandler implements IHandler
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
    }

    /**
     * Главный обработчик callback запросов, определяет запрос
     * и возвращает ответ
     *
     * @return void
     */
    public function handleRequest(): void
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

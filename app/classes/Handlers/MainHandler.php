<?php

declare(strict_types = 1);

namespace classes\Handlers;

use classes\Helpers\LogHelper;
use classes\Handlers\CallbackHandler;
use classes\Handlers\NasaHandler;
use classes\Handlers\BotCommandHandler;
use classes\ButtonRender;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Entities\Message;
use Longman\TelegramBot\Entities\CallbackQuery;

/**
 * Класс маршрутизатор по функционалу бота, определяет
 * какому обработчику отдать запрос
 */
Class MainHandler
{
    /**
     * Объект для получения данных о сообщении и пользователе
     *
     * @var Message
     */
    private Message $message;

    /**
     * Входящий input от пользователя
     *
     * @var Update
     */
    private Update $update;

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
     * Хранение юзера входящего сообщения
     *
     * @var integer
     */
    private int $userID;

    /**
     * Конструктор главного обработчика
     *
     * @param string $update
     */
    public function __construct(string $input)
    {
        $this->update = new Update(json_decode($input, true));
        if ($this->update->getCallbackQuery()) {
            $this->callbackQuery = $this->update->getCallbackQuery();
        } else {
            $this->message = $this->update->getMessage();
            $this->chatID = $this->message->getChat()->getId();
            $this->userID = $this->message->getFrom()->getId();
        }
    }

    /**
     * Паблик метод для идентификации варианта запроса, и последующей передачи для обработки
     *
     * @return void
     */
    public function handleRequest(): void
    {
        if (!empty($this->callbackQuery)) {
            $callbakcHandler = new CallbackHandler($this->callbackQuery);
        } else {
            $entities = $this->message->getEntities();
            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    if ($entity->getType() == 'bot_command') {
                        $botCommand = new BotCommandHandler($this->message);
                    }
                }
            } else {
                $textHandler = new TextMessageHandler($this->message);
            }
        }
    }
}

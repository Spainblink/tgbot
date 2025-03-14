<?php

declare(strict_types=1);

namespace classes\Handlers;

use classes\Helpers\LogHelper;
use classes\Handlers\CallbackHandler;
use classes\Handlers\BotCommandHandler;
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
     * Конструктор главного обработчика
     *
     * @param string $update
     */
    public function __construct(string $input)
    {
        $this->update = new Update(json_decode($input, true));
        $this->initialize();
    }

    /**
     * Инициализирует поля класса обработчика
     *
     * @return void
     */
    private function initialize(): void
    {
        if ($this->update->getCallbackQuery()) {
            $this->callbackQuery = $this->update->getCallbackQuery();
        } else {
            $this->message = $this->update->getMessage();
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
            $callbackHandler = new CallbackHandler($this->callbackQuery);
            $callbackHandler->callbackHandle();
        } else {
            $entities = $this->message->getEntities();
            if (!empty($entities)) {
                foreach ($entities as $entity) {
                    if ($entity->getType() == 'bot_command') {
                        $botCommand = new BotCommandHandler($this->message);
                        $botCommand->botCommandHandle();
                    }
                }
            } else if (!empty($this->message->getText())) {
                $textHandler = new TextMessageHandler($this->message);
                $textHandler->textMessageHandle();
            }
        }
    }
}

<?php

declare(strict_types = 1);

namespace classes;

use classes\LogHelper;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Entities\Message;

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
     * Конструктор главного обработчика
     *
     * @param Update $update
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
        $this->message = $this->update->getMessage();
    }

    /**
     * Приватный метод для идентификации варианта запроса, и последующей передачи для обработки
     *
     * @return void
     */
    public function handleRequest(): void
    {
        $entities = $this->message->getEntities();
        $username = $this->message->getFrom()->getFirstName();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                if ($entity->getType() == 'bot_command') {
                    $this->handleBotCommand($username);
                }
            }
        } else {
            $this->handleMessage($username);
        }

    }

    /**
     * Приватный метод обработки команд
     *
     * @return void
     */
    private function handleBotCommand(string $username): void
    {
        Request::sendMessage([
            'chat_id' => $this->message->getChat()->getId(),
            'text'    => 'Привет, ' . $username . ', я электронный болван - пень 37! Я пока ничего не умею, но скоро меня научит Иван.'
        ]);
    }

    /**
     * Приватный метод обработки сообщений
     *
     * @return void
     */
    private function handleMessage(string $username): void
    {
        Request::sendMessage([
            'chat_id' => $this->message->getChat()->getId(),
            'text'    => 'Отвечать на текстовые сообщения? Сомнительное удовольствие...'
        ]);
    }

}

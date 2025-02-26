<?php

declare(strict_types = 1);

namespace classes\Handlers;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Message;

/**
 * Класс обработчик текстовых сообщений
 */
Class TextMessageHandler
{
    /**
     * Входящее сообщение
     *
     * @var Message
     */
    private Message $message;
    /**
     * Юзернейм для удобства
     *
     * @var string
     */
    private string $username;
    /**
     * ChatID так для удобства
     *
     * @var integer
     */
    private int $chatID;

    /**
     * Конструктор, с определением необходимых полей класса
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->username = $this->message->getFrom()->getFirstName();
        $this->chatID = $this->message->getChat()->getId();
        $this->textMessageHandler();
    }

    /**
     * Основной обработчик текстовых сообщений
     *
     * @return void
     */
    private function textMessageHandler(): void
    {
        Request::sendMessage([
            'chat_id' => $this->chatID,
            'text'    => 'Отвечать на текстовые сообщения? Сомнительное удовольствие... Лучше начни с команды /help.'
        ]);
    }
}

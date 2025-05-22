<?php

declare(strict_types=1);

namespace classes\Handlers;

use classes\Handlers\IHandler;
use classes\Helpers\BaseHelper;
use Longman\TelegramBot\Entities\Message;

/**
 * Клас для отправки стандартного ответа, в случае невозможности обработки типа данных
 */
Class DefaultHandler implements IHandler
{
    /**
     * Входящее сообщение
     *
     * @var Message
     */
    private Message $message;

    /**
     * Конструктор стандартного обработчика, инициализирует входящее сообщение
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    
    /**
     * Обработка запроса, если не нашелся подходящий обработчик
     *
     * @return void
     */
    public function handleRequest(): void
    {
        $chatID = $this->message->getChat()->getId();
        BaseHelper::sendDefaultMessage($chatID);
    }
}

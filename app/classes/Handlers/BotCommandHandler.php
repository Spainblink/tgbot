<?php

declare(strict_types = 1);

namespace classes\Handlers;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Message;
use classes\ButtonRender;
use classes\Helpers\LogHelper;

/**
 * Класс обработчик команд
 */
Class BotCommandHandler
{
    /**
     * Поле для передачи в обработчик
     *
     * @var Message
     */
    private Message $message;
    /**
     * Для обращения по имени к пользователю
     *
     * @var string
     */
    private string $username;
    /**
     * Команда от пользователя
     *
     * @var string
     */
    private string $botCommand;
    /**
     * Для ответа пользователю
     *
     * @var integer
     */
    private int $chatID;

    /**
     * Конструктор класса обработчика, при создании запускает основной метод
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->chatID = $this->message->getChat()->getId();
        $this->username = $this->message->getFrom()->getFirstName();
        $this->botCommand = $this->message->getFullCommand();
        $this->botCommandHandler();
    }

    /**
     * Приватный метод обработки команды
     *
     * @return void
     */
    private function botCommandHandler(): void
    {
        switch ($this->botCommand) {
            case '/start':
                Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text' => 'Выбери интересующее тебя действие.',
                    'reply_markup' => ButtonRender::startKeyboard()
                ]);
            break;
            case '/help':
                Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text'    => 'Привет, ' . $this->username . ', я электронный болван - пень 37! Могу тебя повеселить разными гифками и картинками, или официльными новостями NASA. Это пока весь мой функционал, чтобы начать выполни команду "/start".'
                ]);
            break;
            default:
                Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text'    => 'Привет, ' . $this->username . ', я не знаю такой команды, попробуй начать с /help или /start.'
                ]);
            break;
        }
    }
}

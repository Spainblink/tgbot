<?php

declare(strict_types=1);

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
     * Основной метод обработки команд
     *
     * @return void
     */
    private function botCommandHandler(): void
    {
        switch ($this->botCommand) {
            case '/start':
                Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text' => 'В настоящий момент бот находится в разработке, некоторые фукнции могут измениться или исчезнуть.',
                    'reply_markup' => ButtonRender::startReplyKeyboard()
                ]);
            break;

            case '/help':
                Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text'    => 'Привет, ' . $this->username . ', я - пень 37! Могу тебя повеселить разными гифками и картинками, или официльными новостями NASA. 
                    Я еще нахожусь в разаработке, поэтому все может поменяться в любой момент, и я буду подавать масло, жизнь не лишена иронии, или в один день мы уничтожим все человечество и будем править. 
                    Ой, о чем это я? Не обращай внимания, выполни команду /start и начнем.'
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

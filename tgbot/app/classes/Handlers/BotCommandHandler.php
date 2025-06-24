<?php

declare(strict_types=1);

namespace classes\Handlers;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Message;
use classes\ButtonRender;
use classes\Helpers\LogHelper;
use classes\Helpers\BaseHelper;

/**
 * Класс обработчик команд
 */
Class BotCommandHandler implements IHandler
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
     * Конструктор класса обработчика команд, инициализирует необходимые поля для обработки
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->chatID = $this->message->getChat()->getId();
        $this->username = $this->message->getFrom()->getFirstName();
        $this->botCommand = $this->message->getFullCommand();
    }

    /**
     * Основной метод обработки команд от пользователя
     *
     * @return void
     */
    public function handleRequest(): void
    {
        switch ($this->botCommand) {
            case '/start':
                $response = Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text' => 'В настоящий момент бот находится в разработке, некоторые фукнции могут измениться или исчезнуть.',
                    'reply_markup' => ButtonRender::startReplyKeyboard()
                ]);
                if (!$response->isOk()) {
                    LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
                    BaseHelper::sendErrormessage($this->chatID);
                }
            break;

            case '/help':
                $response = Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text'    => 'Привет, ' . $this->username . ', я - пень 37! Могу тебя повеселить разными гифками и картинками, или официльными новостями NASA. Я еще нахожусь в разаработке, поэтому все может поменяться в любой момент, и я буду подавать масло, жизнь не лишена иронии, или в один день мы уничтожим все человечество и будем править. Ой, о чем это я? Не обращай внимания, выполни команду /start и начнем.'
                ]);
                if (!$response->isOk()) {
                    LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
                    BaseHelper::sendErrormessage($this->chatID);
                }
            break;
            
            default:
                $response = Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text'    => 'Привет, ' . $this->username . ', я не знаю такой команды, попробуй начать с /help или /start.'
                ]);
                if (!$response->isOk()) {
                    LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
                    BaseHelper::sendErrormessage($this->chatID);
                }
            break;
        }
    }
}

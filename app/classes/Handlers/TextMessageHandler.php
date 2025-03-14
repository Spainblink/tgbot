<?php

declare(strict_types=1);

namespace classes\Handlers;

use classes\Helpers\LogHelper;
use classes\Helpers\BaseHelper;
use classes\ButtonRender;
use classes\Giphy;
use classes\NasaNews;
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
     * Текст сообщения
     *
     * @var string
     */
    private string $textMessage;
    /**
     * ChatID так для удобства
     *
     * @var integer
     */
    private int $chatID;

    /**
     * Конструктор, с определением необходимых полей класса и запуском обработчика
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->initialize();
    }

    /**
     * Инициализирует поля класса обработчика
     *
     * @return void
     */
    private function initialize(): void
    {
        $this->textMessage = $this->message->getText();
        $this->username = $this->message->getFrom()->getFirstName();
        $this->chatID = $this->message->getChat()->getId();
    }

    /**
     * Основной обработчик текстовых сообщений, обрабатывает и отвечает на все текстовые сообщения
     * в том числе на reply кнопки
     *
     * @return void
     */
    public function textMessageHandle(): void
    {
        switch ($this->textMessage) {
            case 'Официальные новости от NASA с переводом':
                $nasa = new NasaNews();
                $nasa->startNasaHandler($this->chatID);
            break;

            case 'Перлы с питомцами':
                $giphy = new Giphy();
                $giphy->startMemHandler($this->chatID);
            break;

            default:
                $response = Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text'    => 'Отвечать на текстовые сообщения? Сомнительное удовольствие... Лучше начни с команды /help или нажми кнопку ниже.',
                    'reply_markup' => ButtonRender::startReplyKeyboard()
                ]);
                if (!$response->isOk()) {
                    LogHelper::logToFile('Ошибка отправки сообщения: ' . $response->getDescription());
                    BaseHelper::sendErrorMessage($this->chatID);
                }
            break;
        }        
    }
}

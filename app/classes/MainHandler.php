<?php

declare(strict_types = 1);

namespace classes;

use classes\LogHelper;
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
    private CallbackQuery $callback;

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
            $this->chatID = $this->callbackQuery->getMessage()->getChat()->getId();
            $this->userID = $this->callbackQuery->getMessage()->getFrom()->getId();
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
        if ($this->callbackQuery) {

            //передача в callback обработчик
            $this->handleCallback();
        } else {
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
    }

    /**
     * Приватный метод обработки команд
     *
     * @param string
     * @return void
     */
    private function handleBotCommand(string $username): void
    {
        if ($this->message->getFullCommand() === '/start' || $this->message->getFullCommand() === '/help') {
            Request::sendMessage([
                'chat_id' => $this->chatID,
                'text'    => 'Привет, ' . $username . ', я электронный болван - пень 37! В скором будущем я буду выполнять простые арифметические действия и присылать в переводе официальные новости NASA.',
                'reply_markup' => ButtonRender::startKeyboard()
            ]);
        } else {
            Request::sendMessage([
                'chat_id' => $this->chatID,
                'text'    => $username . ', я не знаю команды '. $this->message->getFullCommand() .', но возможно в будущем научусь.'
            ]);
        }
    }

    /**
     * Приватный метод обработки callback запросов
     *
     * @return void
     */
    private function handleCallback(): void
    {
        $callbackData = $this->callbackQuery->getData();
        switch($callbackData) {
            case 'comparePrice':
                Request::sendMessage([
                    'chat_id' => $this->chatID,
                    'text'    => 'Функция в находтся в разработке.'                    
                ]);
            break;

            case 'nasa':
                NasaHandler::startNasaHandler($this->chatID);
            break;

            case 'APOD':
                NasaHandler::sendAPOD($this->chatID);
            break;
        }
        
    }

    /**
     * Приватный метод обработки текстовых сообщений
     *
     * @param string
     * @return void
     */
    private function handleMessage(string $username): void
    {
        Request::sendMessage([
            'chat_id' => $this->message->getChat()->getId(),
            'text'    => 'Отвечать на текстовые сообщения? Сомнительное удовольствие... Попробуй начать с комманды /start или /help.'
        ]);
    }

}

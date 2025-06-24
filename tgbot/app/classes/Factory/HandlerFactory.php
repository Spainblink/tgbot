<?php

declare(strict_types=1);

namespace classes\Factory;

use classes\Handlers\CallbackHandler;
use classes\Handlers\BotCommandHandler;
use classes\Handlers\TextMessageHandler;
use classes\Handlers\DefaultHandler;
use classes\Handlers\IHandler;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Entities\Message;

/**
 * Класс фабрика для создания обработчика
 */
Class HandlerFactory
{
    /**
     * Метод создает и возвращает подходящий обработчик на входящий инпут
     *
     * @param string $input - входящие данные
     * @return IHandler
     */
    public function createHandler(string $input): IHandler
    {
        $update = new Update(json_decode($input, true));
        $callbackQuery = $update->getCallbackQuery() ?? '';
        if (!empty($callbackQuery)) {
            return new CallbackHandler($callbackQuery);
        }
        $message = $update->getMessage();
        
        return $this->createMessageHandler($message);
    }

    /**
     * Приватный доп. метод для определения нужного обработчика если это не callback или inline
     * в дальнейшем планирую добавить обработку фото, видео, голосовых сообщений, заранее разделил логику
     *
     * @param [type] $message
     * @return IHandler
     */
    private function createMessageHandler(Message $message): IHandler
    {
        $entities = $message->getEntities();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                if ($entity->getType() == 'bot_command') {
                    return new BotCommandHandler($message);
                }
            }
        } else if (!empty($message->getText())) {
            return new TextMessageHandler($message);
        }
        
        return new DefaultHandler($message);
    }
}

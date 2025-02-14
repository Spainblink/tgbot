<?php

declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';

use classes\MainHandler;
use classes\LogHelper;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Update;

$botToken = getenv('BOT_TOKEN');
$botName = getenv('BOT_NAME');

try {
    $telegram = new Telegram($botToken, $botName);
} catch (Exception $e) {
    LogHelper::logToFile("Ошибка при создании объекта Telegram: " . $e->getMessage());
    exit;
}

if ($telegram->handle()) {
    $input = Request::getInput();
    if ($input) {
        $update = new Update(json_decode($input, true));
        $handle = new MainHandler($update);
        $handle->handleRequest();
    } else {
        LogHelper::logToFile("Ошибка: Нет входящих данных.");
    }

} else {
    LogHelper::logToFile("Ошибка: Не удалось обработать запрос.");
}

<?php

require __DIR__ . '/../vendor/autoload.php';

use Longman\TelegramBot\Telegram;

$botToken = getenv('BOT_TOKEN');
$botName = getenv('BOT_NAME');
$urlHook = 'https://spainblink.ru/index.php';

try {
    $telegram = new Telegram($botToken, $botName);
    $result = $telegram->setWebhook($urlHook);
    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}

<?php

declare(strict_types = 1);

namespace Classes;

use classes\LogHelper;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;

/**
 * Класс со статичными методами для рендера всех callback кнопок
 */
Class ButtonRender
{
    /**
     * Статичный метод рендера на команду /start или /help
     *
     * @return InlineKeyboard
     */
    public static function startKeyboard(): InlineKeyboard
    {
        $compareBtn = new InlineKeyboardButton(['text' => 'Сравнение стоимости', 'callback_data' => 'comparePrice']);
        $nasaBtn = new InlineKeyboardButton(['text' => 'Новости NASA', 'callback_data' => 'nasa']);
        $keyboard = new InlineKeyboard([$compareBtn], [$nasaBtn]);
        
        return $keyboard;
    }

    /**
     * Статичный метод в ответ на callback сравнения стоимости
     *
     * @return InlineKeyboard
     */
    public static function compareKeyboard(): InlineKeyboard
    {
        $confirmBtn = new InlineKeyboardButton(['text' => 'Рассчитать', 'callback_data' => 'arifmeticData']);
        $keyboard = new InlinKeyboard([$confirmBtn]);

        return $keyboard;
    }

    /**
     * Статичный метод, рендер кнопок NasaNews
     *
     * @return InlineKeyboard
     */
    public static function nasaNewsKeyboard(): InlineKeyboard
    {
        $getAPOD = new InlineKeyboardButton(['text' => 'Астрофотография дня', 'callback_data' => 'APOD']);
        $keyboard = new InlineKeyboard([$getAPOD]);

        return $keyboard;
    }
}

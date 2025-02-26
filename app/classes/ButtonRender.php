<?php

declare(strict_types = 1);

namespace classes;

use classes\Helpers\LogHelper;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;

/**
 * Класс со статичными методами для рендера всех callback кнопок
 */
Class ButtonRender
{
    /**
     * Метод для кнопки вернуться в основное меню
     *
     * @return InlineKeyboardButton
     */
    private static function getBackToMainMenuButton(): InlineKeyboardButton
    {
        return new InlineKeyboardButton(['text' => 'Вернуться в главное меню', 'callback_data' => 'mainMenu']);
    }

    /**
     * Статичный метод рендера на команду /start или callback вернуться в меню
     *
     * @return InlineKeyboard
     */
    public static function startKeyboard(): InlineKeyboard
    {
        $nasaBtn = new InlineKeyboardButton(['text' => 'Новости NASA', 'callback_data' => 'nasa']);
        $memBtn = new InlineKeyboardButton(['text' => 'Картинки и gif', 'callback_data' => 'mems']);
        $keyboard = new InlineKeyboard([$nasaBtn], [$memBtn]);

        return $keyboard;
    }

    /**
     * Статичный метод рендера кнопок для мемов, гифок, картинок
     *
     * @return InlineKeyboard
     */
    public static function getMemKeyboard(): InlineKeyboard
    {
        $getCatGifBtn = new InlineKeyboardButton(['text' => 'gif с котиком', 'callback_data' => 'getCatGif']);
        $getDogGifBtn = new InlineKeyboardButton(['text' => 'gif с собачкой', 'callback_data' => 'getDogGif']);
        $getRandomGifBtn = new InlineKeyboardButton(['text' => 'случайная gif', 'callback_data' => 'getRandGif']);
        $getDogBtn = new InlineKeyboardButton(['text' => 'фото собачки', 'callback_data' => 'getDog']);
        $keyboard = new InlineKeyboard([$getCatGifBtn, $getRandomGifBtn], [$getDogGifBtn, $getDogBtn], [self::getBackToMainMenuButton()]);

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
        $keyboard = new InlineKeyboard([$getAPOD], [self::getBackToMainMenuButton()]);

        return $keyboard;
    }
}

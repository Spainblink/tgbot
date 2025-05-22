<?php

declare(strict_types=1);

namespace classes;

use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\KeyboardButton;

/**
 * Класс со статичными методами для рендера всех callback кнопок
 */
Class ButtonRender
{

    /**
     * Статичный метод рендера reply кнопок на команду /start
     *
     * @return Keyboard
     */
    public static function startReplyKeyboard(): Keyboard
    {
        $memBtn = new KeyboardButton('Перлы с питомцами');
        $nasaBtn = new KeyboardButton('Официальные новости от NASA с переводом');
        $keyboard = new Keyboard([$memBtn], [$nasaBtn]);
        $keyboard->setResizeKeyboard(true);
        $keyboard->setIsPersistent(true);

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
        $keyboard = new InlineKeyboard([$getCatGifBtn, $getRandomGifBtn], [$getDogGifBtn, $getDogBtn]);

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

<?php

declare(strict_types=1);

namespace classes\Handlers;

/**
 * Интерфейс всех обработчиков
 */
Interface IHandler
{
    /**
     * Основной метод обработки входящего сообщения
     *
     * @return void
     */
    public function handleRequest(): void;
}
<?php

declare(strict_types=1);

namespace classes\Handlers;

/**
 * Интерфейс всех обработчиков
 */
Interface IHandler
{
    public function handleRequest(): void;
}
<?php

namespace PinaNotifications\Transports;

use PinaNotifications\Messages\Message;

interface TransportInterface
{
    /** Транспорт должен предоставить метод отправки сообщение по указанному адресу
     * И вернуть true, если попытка отправки состоялась
     * Или false, если отправка невозможна (адрес недостижим для отправки),
     * чтобы система попыталась найти другой транспорт в порядке приоритета
     */
    public function send(string $address, Message $message): bool;
}
<?php

namespace PinaNotifications\Transports;

use PinaNotifications\Messages\Message;

class StackExampleTransport implements TransportInterface
{

    protected $buffer = [];

    /**
     * @inheritDoc
     */
    public function send(string $address, Message $message): bool
    {
        array_push($this->buffer, $message);
        return true;
    }

    public function pop(): ?Message
    {
        return array_pop($this->buffer);
    }
}
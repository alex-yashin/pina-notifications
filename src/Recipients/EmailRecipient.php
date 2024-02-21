<?php

namespace PinaNotifications\Recipients;

use PinaNotifications\Messages\Message;
use PinaNotifications\Transports\TransportRegistry;

class EmailRecipient implements RecipientInterface
{
    protected $email = '';

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function notify(Message $message): bool
    {
        return TransportRegistry::get('email')->send($this->email, $message);
    }

}
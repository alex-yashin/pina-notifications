<?php

namespace PinaNotifications\Recipients;

use PinaNotifications\Messages\Message;
use PinaNotifications\Transports\TransportRegistry;

class PhoneRecipient implements RecipientInterface
{
    protected $phone = '';

    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

     public function notify(Message $message): bool
     {
         return TransportRegistry::get('phone')->send($this->phone, $message);
     }
}
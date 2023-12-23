<?php

namespace PinaNotifications\Recipients;

use PinaNotifications\Messages\Message;
use PinaNotifications\Transports\TransportRegistry;

class PhoneRecipient implements RecipientInterface
{
    protected string $phone = '';

    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

     public function notify(Message $message)
     {
         return TransportRegistry::get('phone')->send($this->phone, $message);
     }
}
<?php

namespace PinaNotifications\Recipients;

use PinaNotifications\Messages\Message;

interface RecipientInterface
{
    public function notify(Message $message): bool;
}
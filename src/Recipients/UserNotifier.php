<?php

namespace PinaNotifications\Recipients;

use PinaNotifications\Messages\Message;

class UserNotifier
{
    public function notify($userId, Message $message): bool
    {
        $recipient = new UserRecipient($userId);
        return $recipient->notify($message);
    }
}
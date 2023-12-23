<?php

namespace PinaNotifications\Recipients;

use PinaNotifications\Addresses\AddressResolverRegistry;
use PinaNotifications\Messages\Message;
use PinaNotifications\Transports\TransportInterface;
use PinaNotifications\Transports\TransportRegistry;

class UserRecipient implements RecipientInterface
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function notify(Message $message)
    {
        $transports = $this->resolveTransports();
        foreach ($transports as $type => $transport) {
            $address = AddressResolverRegistry::get($type)->resolve($this->userId);
            if (empty($address)) {
                continue;
            }
            if ($transport->send($address, $message)) {
                break;
            }
        }
    }

    /**
     * Возвращает список транспортов в виде ассоциативного массива ключ => TransportInterface
     * @return TransportInterface[]
     */
    protected function resolveTransports()
    {
        return TransportRegistry::getAllExcept([]);
    }

}
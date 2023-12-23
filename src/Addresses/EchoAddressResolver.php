<?php


namespace PinaNotifications\Addresses;


class EchoAddressResolver implements AddressResolverInterface
{

    public function resolve($userId): string
    {
        return $userId;
    }

}
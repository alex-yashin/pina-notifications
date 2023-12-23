<?php


namespace PinaNotifications\Addresses;


interface AddressResolverInterface
{

    public function resolve($userId): string;

}
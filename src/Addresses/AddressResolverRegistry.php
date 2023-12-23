<?php


namespace PinaNotifications\Addresses;


class AddressResolverRegistry
{

    protected static $list = [];


    public static function set($type, AddressResolverInterface $resolver)
    {
        static::$list[$type] = $resolver;
    }

    public static function get($type): AddressResolverInterface
    {
        if (!isset(static::$list[$type])) {
            return new EchoAddressResolver();
        }
        return static::$list[$type];
    }

}
<?php

namespace PinaNotifications\Transports;

use Pina\Container\NotFoundException;

class TransportRegistry
{

    protected static $list = [];


    public static function set($type, TransportInterface $transport)
    {
        static::$list[$type] = $transport;
    }

    public static function get($type): TransportInterface
    {
        if (!isset(static::$list[$type])) {
            throw new NotFoundException();
        }
        return static::$list[$type];
    }

    /**
     * Выбирает все транспорты кроме указанных
     * @param string[] $ignoredTypes
     * @return TransportInterface[]
     */
    public static function getAllExcept(array $ignoredTypes): array
    {
        $r = [];
        foreach (static::$list as $type => $transport) {
            if (in_array($type, $ignoredTypes)) {
                continue;
            }
            $r[$type] = $transport;
        }
        return $r;
    }

}
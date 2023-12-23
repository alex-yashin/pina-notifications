<?php

namespace PinaNotifications;

use Pina\ModuleInterface;

class Module implements ModuleInterface
{
    public function getPath()
    {
        return __DIR__;
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getTitle()
    {
        return 'Notifications';
    }

    public function __construct()
    {
    }

    public function http()
    {
    }

    public function boot()
    {
    }
}
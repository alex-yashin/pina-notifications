<?php

namespace PinaNotifications\Messages;

class Message
{

    protected $title = '';
    protected $text = '';
    protected $link = '';
    public function __construct(string $title, string $text, string $link = '')
    {
        $this->title = $title;
        $this->text = $text;
        $this->link = $link;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function __toString()
    {
        return implode(
            "\r\n",
            array_filter(
                [
                    $this->getTitle(),
                    $this->getText(),
                    $this->getLink()
                ]
            )
        );
    }

}
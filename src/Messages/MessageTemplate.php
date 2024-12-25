<?php

namespace PinaNotifications\Messages;

use Exception;
use Pina\Http\Url;

class MessageTemplate extends Message
{
    use TemplateTrait;

    protected $data = [];

    public function setData(array $data)
    {
        $this->data  = $data;
    }

    public function getTitle(): string
    {
        return $this->template($this->title, $this->data);
    }

    public function getText(): string
    {
        return $this->template($this->text, $this->data);
    }

    public function getLink(): Url
    {
        $link = $this->link instanceof UrlTemplate ? $this->link->make($this->data) : $this->link;
        return $link ?? new Url('');
    }

    /**
     * @param array $data
     * @return Message
     * @throws Exception
     */
    public function make(array $data)
    {
        $link = $this->link instanceof UrlTemplate ? $this->link->make($data) : $this->link;
        return new Message(
            $this->template($this->title, $data),
            $this->template($this->text, $data),
            $link,
        );
    }

}
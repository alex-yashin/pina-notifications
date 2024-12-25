<?php

namespace PinaNotifications\Messages;

use Exception;

class MessageTemplate extends Message
{
    use TemplateTrait;

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
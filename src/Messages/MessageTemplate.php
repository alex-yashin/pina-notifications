<?php

namespace PinaNotifications\Messages;

use Exception;

class MessageTemplate extends Message
{
    /**
     * @param array $data
     * @return Message
     * @throws Exception
     */
    public function make(array $data)
    {
        return new Message(
            $this->template($this->title, $data),
            $this->template($this->text, $data),
            $this->template($this->link, $data),
        );
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws Exception
     */
    protected function template(string $template, array $data): string
    {
        $searchStrings = [];
        $replaceStrings = [];
        foreach ($data as $key => $value) {
            $searchStrings[] = "%$key%";
            $replaceStrings[] = $value;
        }

        $result = str_replace($searchStrings, $replaceStrings, $template);

        if ($this->hasUnreplaced($result)) {
            throw new Exception('Недостаточно данных для шаблона');
        }

        return $result;
    }


    private function hasUnreplaced(string $text): bool
    {
        return preg_match("/%[\S]+%/", $text);
    }

}
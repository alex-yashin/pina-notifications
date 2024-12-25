<?php

namespace PinaNotifications\Messages;

trait TemplateTrait
{

    /**
     * @param string $template
     * @param array $data
     * @return string
     * @throws \Exception
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
            throw new \Exception('Недостаточно данных для шаблона');
        }

        return $result;
    }


    private function hasUnreplaced(string $text): bool
    {
        return preg_match("/%[\S]+%/", $text);
    }

}
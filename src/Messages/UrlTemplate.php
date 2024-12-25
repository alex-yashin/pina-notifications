<?php

namespace PinaNotifications\Messages;

use Pina\App;
use Pina\Http\Url;

class UrlTemplate extends Url
{
    use TemplateTrait;

    protected $params = [];

    public function __construct(string $pattern, $params = array())
    {
        parent::__construct($pattern);
        $this->params = $params;
    }

    public function make($data): Url
    {
        $params = $this->params;
        foreach ($params as $k => $v) {
            $params[$k] = $this->template($v, $data);
        }
        return new Url(App::link($this->url, $params));
    }

    public function __toString()
    {
        foreach  ($this->params as $v) {
            if ($this->hasUnreplaced($v)) {
                throw new \Exception('Недостаточно данных для шаблона');
            }
        }
        return App::link($this->url, $this->params);
    }

}
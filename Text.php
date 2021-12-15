<?php

class Text
{
    private $text;

    public function __construct(string $str = '')
    {
        $this->$text = $str;
    }

    public function getLength()
    {
        return mb_strlen($this->$text, 'UTF-8');
    }

    public function add(string $str)
    {
        $this->$text .= $str;
    }

    public function clear()
    {
        $this->$text = "";
    }

    public function get()
    {
        return $this->$text;
    }

    public function set(string $newText = "")
    {
        echo($this->$text);
        $this->$text = $newText;
    }

    public function print()
    {
        echo $this->$text . "<br>";
    }
}
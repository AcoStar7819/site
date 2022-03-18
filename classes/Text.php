<?php

namespace classes;

/**
 * Бесполезный класс созданный в процессе обучения.
 */
class Text
{
    public function __construct(private string $text = '')
    {
    }

    /**
     * Длина хранимого текста
     * @return int
     */
    public function getLength(): int
    {
        return mb_strlen($this->text, 'UTF-8');
    }

    /**
     * Конкатенация с хранимым текстом
     * @param string $str
     * @return void
     */
    public function add(string $str)
    {
        $this->text .= $str;
    }

    /**
     * Очистка хранимого текста
     * @return void
     */
    public function clear()
    {
        $this->text = "";
    }

    /**
     * Получение хранимого текста
     * @return string
     */
    public function get(): string
    {
        return $this->text;
    }

    /**
     * Установка хранимого текста
     * @param string $newText
     * @return void
     */
    public function set(string $newText = "")
    {
        echo($this->text);
        $this->text = $newText;
    }

    /**
     * Вывод хранимого текста
     * @return void
     */
    public function print()
    {
        echo $this->text . "<br>";
    }
}
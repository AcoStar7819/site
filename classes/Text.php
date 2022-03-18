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

    /**
     * Генерация строки из случайных символов
     *
     * @param int $length
     * @return string
     */
    public static function randomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
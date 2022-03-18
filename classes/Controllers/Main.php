<?php

namespace classes\Controllers;

class Main
{
    public static function render()
    {
        // Получение ответа сервера
        $response = "";
        if (isset($_GET["name"]) && isset($_GET["age"]) && isset($_GET["date"]))
        {
            $name = htmlspecialchars($_GET["name"]);
            $age = htmlspecialchars($_GET["age"]);
            $date = strtotime(htmlspecialchars($_GET["date"]));
            if ($name != "" && $age != "" && $date != "")
            {
                if (is_numeric($age) && ($age >= 10 && $age <= 100))
                {
                    # Демонстрация работы тестового класса "Text"
                    $name = new \classes\Text($name);
                    $response .= "<strong>" . $name->get() . "</strong><br>Длина имени: " . $name->getLength() . "<br>";

                    $response .= "Возраст: " . $age . "<br>";
                    $response .= "Дата: " . \classes\Date::getFormattedDate($date);
                }
            }
        }

        // Отображение финальной страницы
        echo render('./Templates/layout.php', [
            'title' => 'Форма',
            'content' => render('./Templates/main.php', [
                'response' => $response
            ])
        ]);
    }
}
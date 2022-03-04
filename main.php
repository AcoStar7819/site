<?php
    include('./classes/Date.php');
    include('./classes/Text.php');
?>
<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Dev</title>
    </head>
    <body>
        <div class="navigation">
            <a href="/">Основная страница</a>
            <a href="/news">Новости</a>
        </div>
        <div class="line">
            <div class="panel">
                <h1>Отправка данных</h1>
                <form action="/" method="get" target="_self" autocomplete="off" id="defaultForm">
                    <label for="name">Имя</label>
                    <input type="text" name="name" required>
                    <label for="age">Возраст</label>
                    <input type="number" name="age" min="10" max="100" required>
                    <label for="date">Дата рождения</label>
                    <input type="date" name="date" required>
                    <input type="submit" value="Отправить на сервер" disabled>
                </form>
            </div>
            <div class="panel">
                <h1>Ответ сервера</h1>
                <p class="response">
                    <?php
                        if (isset($_GET["name"]) && isset($_GET["age"]) && isset($_GET["date"]))
                        {
                            $name = htmlspecialchars($_GET["name"]);
                            $age = htmlspecialchars($_GET["age"]);
                            $date = strtotime(htmlspecialchars($_GET["date"]));
                            if ($name != "" && $age != "" && $date != "")
                            {
                                if (is_numeric($age) && ($age >= 10 && $age <= 100))
                                {
                                    #   Демонстрация новосозданного класса "Text"
                                    $name = new Text($name);
                                    echo "<strong>" . $name->get() . "</strong><br>Длина имени: " . $name->getLength() . "<br>";

                                    echo "Возраст: " . $age . "<br>";
                                    echo "Дата: " . Date::getFormattedDate($date);
                                }
                            }
                        }
                    ?>
                </p>
            </div>
        </div>
        <script src="script.js"></script>
    </body>
</html>
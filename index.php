<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Dev</title>
    </head>
    <body>
        <div class="line">
            <div class="panel">
                <h1>Отправка данных</h1>
                <form action="index.php" method="get" target="_self" autocomplete="off" id="userInfoForm">
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
                        $date_m = [
                            'января',
                            'февраля',
                            'марта',
                            'апреля',
                            'мая',
                            'июня',
                            'июля',
                            'августа',
                            'сентября',
                            'октября',
                            'ноября',
                            'декабря',
                        ];

                        function GetFormattedDate($timestamp)
                        {
                            global $date_m;
                            return date('j ' . $date_m[date('m', $timestamp) - 1] . ' Y года', $timestamp);
                        }

                        if (isset($_GET["name"]) && isset($_GET["age"]) && isset($_GET["date"]))
                        {
                            $name = htmlspecialchars($_GET["name"]);
                            $age = htmlspecialchars($_GET["age"]);
                            $date = strtotime(htmlspecialchars($_GET["date"]));
                            if ($name != "" && $age != "" && $date != "")
                            {
                                if (is_numeric($age) && ($age >= 10 && $age <= 100))
                                {
                                    echo "<strong>" . $name . "</strong><br>Длина имени: " . mb_strlen($name, 'UTF-8') . "<br>";
                                    echo "Возраст: " . $age . "<br>";
                                    echo "Дата: " . GetFormattedDate($date);
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
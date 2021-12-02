<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Dev</title>
		<script src="script.js"></script>
    </head>
    <body>
        <div class="line">
            <div class="panel">
                <h1>Отправка данных</h1>
                <form action="index.php" method="get" target="_self" autocomplete="off">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" required>
                    <label for="age">Возраст</label>
                    <input type="number" id="age" name="age" min="10" max="100" required>
                    <input type="submit" id="submit" value="Отправить на сервер" disabled>
                </form>
            </div>
            <div class="panel">
                <h1>Ответ сервера</h1>
                <p class="response">
                    <?php
                        if (isset($_GET["name"]))
                            $name = htmlspecialchars($_GET["name"]);
                        if (isset($_GET["age"]))
                            $age = htmlspecialchars($_GET["age"]);

                        //  Если есть имя - отображаем его
                        if ($name && $name != "")
                            echo "<strong>" . $name . "</strong><br>Длина имени: " . mb_strlen($name, 'UTF-8') . "<br>";
                        else
                            echo "Имя не указано.<br>";
                        //  Если есть возраст - отображаем его
                        if ($age && $age != "")
                            echo "Возраст: " . $age;
                        else
                            echo "Возраст не указан.";
                    ?>
                </p>
            </div>
        </div>  
    </body>
</html>
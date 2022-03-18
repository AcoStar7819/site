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
        <?= $response ?>
    </p>
</div>
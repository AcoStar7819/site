<div class="panel">
    <h1>Аккаунт</h1>
    <p class="response">
        Логин: <?= $login; ?><br>
        ID аккаунта: <?= $id; ?>
    </p>
    <p>
        <form action="../../account" method="post" target="_self">
            <input type="hidden" name="logout" value="1" />
            <input type="submit" value="Выйти">
        </form>
    </p>
</div>
<div class="panel">
    <h1>Авторизация</h1>
    <form action="../../account" method="post" target="_self" autocomplete="off" id="defaultForm">
        <input type="hidden" name="auth" value="0"/>
        <label for="title">Логин</label>
        <input type="text" name="login" required>
        <label for="text">Пароль</label>
        <input type="password" name="password" required>
        <input type="submit" value="Войти" disabled>
    </form>
</div>
<div class="panel">
    <h1>Регистрация</h1>
    <form action="../../account" method="post" target="_self" autocomplete="off" id="regForm">
        <input type="hidden" name="auth" value="1"/>
        <label for="title">Логин</label>
        <input type="text" name="login" required>
        <label for="text">Пароль</label>
        <input type="password" name="password" required>
        <input type="submit" value="Зарегестрироваться" disabled>
    </form>
    <script>
        let regCheckList = document.querySelectorAll("#regForm input:not(input[type=submit])");
        let regButton = document.querySelector("#regForm input[type=submit]");

        for (let i = 0; i < regCheckList.length; i++) {
            regCheckList[i].addEventListener("change", function () {
                UpdateSubmitButton(regButton, regCheckList);
            });
        }

        if (<?=$authError?>) {
            alert("Ошибка авторизации.");
        }
    </script>
</div>
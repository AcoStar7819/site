<div class="panel" style="margin-bottom: auto;">
    <h1>Создать новость</h1>
    <span>Язык: <?= \classes\Storages\LocalesStore::getName($localeId) ?></span>
    <form action="../../news" method="post" target="_self" autocomplete="off" id="defaultForm">
        <label for="title">Заголовок</label>
        <input type="text" name="title" required>
        <label for="text">Текст</label>
        <input type="text" name="text" required>
        <input type="submit" value="Отправить на сервер" disabled>
    </form>
</div>
<div class="panel">
    <h1>Новости</h1>
    <!--    Загрузка новостей   -->
    <?= $loadedNews ?>
    <!--    Переключение страниц    -->
    <div class="pagesNav">
        <form action="../../news" method="post" target="_self" style="
                        display: flex;
                        align-items: center;
                        width: 100%;
                    ">
            <input type="hidden" name="newPageId" value="" id="curPage"/>
            <input type="submit" value="Назад" onclick="setPage(<?= $pageId ?> - 1)">
            <span style=" display: block; margin-top: 15px; "><?= $pageId ?></span>
            <input type="submit" value="Вперёд" onclick="setPage(<?= $pageId ?> + 1)">
        </form>
    </div>
</div>
<script>
    function setPage(newPageId) {
        document.querySelector("#curPage").value = newPageId;
    }

    function setLanguage(newLanguage) {
        console.log(newLanguage);
        document.querySelector("#curLocale").value = newLanguage;
    }
</script>
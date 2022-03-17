<?php
$db = new \classes\Storages\NewsStore();
$pageId = 1;
if (isset($_COOKIE["pageId"])) {
    $pageId = (int)$_COOKIE["pageId"];
}
if (isset($_POST["newPageId"])) {
    $pageId = (int)$_POST["newPageId"];
    setcookie("pageId", $pageId);
}

$localeId = 1;
if (isset($_COOKIE["localeId"])) {
    $localeId = (int)$_COOKIE["localeId"];
}
if (isset($_POST["newLocaleId"])) {
    $localeId = (int)$_POST["newLocaleId"];
    setcookie("localeId", $localeId);
}
?>

<div class="panel" style="margin-bottom: auto;">
    <h1>Создать новость</h1>
    <span>Язык: <?= \classes\Storages\LocalesStore::getName($localeId) ?></span>
    <form action="../../news" method="post" target="_self" autocomplete="off" id="defaultForm">
        <label for="title">Заголовок</label>
        <input type="text" name="title" required>
        <label for="text">Текст</label>
        <input type="text" name="text" required>
        <input type="submit" value="Отправить на сервер" disabled>
        <?php
        if (isset($_POST["title"]) && isset($_POST["text"])) {
            $title = htmlspecialchars($_POST["title"]);
            $text = htmlspecialchars($_POST["text"]);
            if ($title != "" && $text != "") {
                $db->addNews($title, $text, $localeId);
                header('Refresh:0; url=news');
            }
        }
        ?>
    </form>
</div>
<div class="panel">
    <h1>Новости</h1>
    <!--    Загрузка новостей   -->
    <?php
    $news = $db->getNews($pageId, $localeId);
    if ($news and count($news) > 0) {
        foreach ($news as $collection) {
            echo "<div class=\"news\"><h2>" . $collection->title . "</h2>" .
                $collection->text .
                "<em>Опубликовано " . $collection->date . "</em></div>";
        }
    } else {
        echo "<strong>Новостей нет.</strong>";
    }
    ?>
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
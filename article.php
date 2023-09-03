<?php
session_start();
require_once "app/lib/functions.php";
require_once "app/class/Database.php";

$db = new Database();

// Get article id
if (!empty($_GET["article"])) {
    $article_id = $_GET["article"];
    $article = $db->get_article($article_id);
}
// Add and Get comments
add_comment($db, $article_id);
$comments = $db->get_comments($article_id);

$title_name = $article["header"];
require_once "app/default/header.php";

?>

<div class="d-flex flex-column article__container">
    <h1 class="display-6"><?= $article["header"] ?></h1>
    <div class="d-flex flex-column article__text-container">
        <p class="article__text"><?= $article["short_desc"] ?></p>
        <p class="article__text"><?= $article["description"] ?></p>
        <p class="article__date"><?= $article["date"] ?></p>
    </div>

    <?php if (isset($_SESSION["access"])) : ?>
        <form class="article__comment-form" action="<?= $_SERVER["REQUEST_URI"] ?>" method="post">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Ваше имя</label>
                <input type="form-control" class="form-control" id="exampleFormControlTextarea1" placeholder="Имя" name="name_comment">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea2" class="form-label">Текст комментария</label>
                <textarea class="form-control" id="exampleFormControlTextarea2" rows="3" placeholder="Текст..." name="text_comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    <?php else : ?>
        <p class="alert alert-primary my-4">Оставлять комментарии могут только зарегестрированные пользователи</p>
    <?php endif; ?>

    <?php foreach ($comments as $comment) : ?>
        <div class="card bg-info-subtle article__comment-item">
            <div class="card-body">
                <h5 class="card-title"><?= $comment["name"] ?></h5>
                <p class="card-text"><?= $comment["text"] ?></p>
                <p class="card-text"><?= $comment["date"] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php

require_once "app/default/footer.php";

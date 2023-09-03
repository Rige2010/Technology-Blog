<?php
session_start();
require_once "app/lib/functions.php";
require_once "app/class/Database.php";

$db = new Database();

$articles_on_page = number_per_page();
$count_pages = ceil($db->get_articles_count() / $articles_on_page);

$current_page = check_correct_page($count_pages);

$articles = $db->get_articles_orderDesc($articles_on_page, $current_page);

$title_name = "Technology Blog";
require_once "app/default/header.php";

?>

<h2 class="text-center mt-5 mb-4">Статьи</h2>

<div class="container d-flex flex-column align-items-center" style="max-width: 600px;">
    <form class="d-flex align-self-end" action="index.php" method="post">
        <label for="on-page" style="margin-right: 10px;">На странице</label>
        <select name="on-page" id="on-page" class="" aria-label="Small select example" style="margin-right: 10px;">
            <option style="color: #a1a1a1;" selected disabled><?= $articles_on_page ?></option>
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="10">10</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">&raquo;</button>
    </form>
    <?php foreach ($articles as $article) : ?>
        <div class="card my-3 w-100">
            <div class="card-header">
                <a href="article.php?article=<?= $article["id"] ?>"><?= $article["header"] ?></a>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="card-text" style="max-width: 300px;"><?= $article["short_desc"] ?></p>
                <span class="align-self-end"><?= $article["date"] ?></span>
            </div>
        </div>
    <?php endforeach; ?>
    <nav>
        <ul class="pagination mb-5">
            <?php if ($current_page != 1) : ?>
                <li class="page-item ms-1"><a class="page-link" href="?page=1">Первая</a></li>
                <li class="page-item"><a class="page-link" href="?page=<?= $current_page - 1; ?>">&laquo;</a></li>
            <?php endif; ?>
            <?php if ($current_page != $count_pages) : ?>
                <li class="page-item"><a class="page-link" href="?page=<?= $current_page + 1; ?>">&raquo;</a></li>
                <li class="page-item me-1"><a class="page-link" href="?page=<?= $count_pages ?>">Последняя</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php

require_once "app/default/footer.php";

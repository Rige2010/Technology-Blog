<?php error_reporting(-1);

require_once "app/lib/functions.php";

logout();

?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css">
    <title><?= $title_name ?></title>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary text-primary-emphasis">
        <div class="container-fluid">
            <a class="navbar-brand ms-4" href="index.php">Technology Blog</a>
            <button class="navbar-toggler me-4" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item me-3">
                        <a class="nav-link text-dark" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-body-tertiary" href="#">О проекте</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-body-tertiary" href="#">Контакты</a>
                    </li>
                    <?php if (!isset($_SESSION["access"])) : ?>
                        <li class="nav-item me-4">
                            <a class="nav-link text-primary" href="signup.php">Регистрация</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="signin.php" role="button">Вход</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="?do=logout" role="button">Выйти</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION["success"])) : ?>
        <h5 class="mt-4 alert alert-success text-center"><?= $_SESSION["success"] ?></h5>
        <?php unset($_SESSION["success"]) ?>
    <?php endif; ?>
    <?php if (isset($_SESSION["error"])) : ?>
        <h5 class="mt-4 alert alert-danger text-center"><?= $_SESSION["error"] ?></h5>
        <?php unset($_SESSION["error"]) ?>
    <?php endif; ?>
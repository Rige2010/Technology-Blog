<?php

// Logout User
function logout(): void
{
    if (!empty($_GET["do"]) && $_GET["do"] === "logout") {
        $_SESSION["success"] = "Сеанс завершён";
        unset($_SESSION["access"]);
        header("location: {$_SERVER["HTTP_REFERER"]}");
        die;
    }
}

// Cheking the correct page
function check_correct_page($count_pages)
{
    if (empty($_GET["page"]) || $_GET["page"] < 1 || $_GET["page"] > $count_pages) {
        return  1;
    } else {
        return $_GET["page"];
    }
}

// Number of articles per page
function number_per_page(): int
{
    if (!empty($_POST["on-page"])) {
        $_SESSION["on-page"] = $_POST["on-page"];
        $articles_on_page = ($_POST["on-page"]);
    } else {
        if (!empty($_SESSION["on-page"])) {
            $articles_on_page = ($_SESSION["on-page"]);
        } else {
            $articles_on_page = 10;
        }
    }
    return $articles_on_page;
}

// Page access check
function page_access_check(): void
{
    if (!empty($_SESSION["access"])) {
        header("location: index.php");
        die;
    }
}

// Check and SignUp
function signup($db): void
{
    if (!empty($_POST)) {
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        $password_repeat = htmlspecialchars(trim($_POST["password-repeat"]));
        if (empty($email) || empty($password) || empty($password_repeat)) {
            $_SESSION["error"] = "Все поля должны быть заполнены";
            header("location: {$_SERVER["PHP_SELF"]}");
            die;
        }
        if ($db->exists_user($email)) {
            $_SESSION["error"] = "Пользователь с таким email уже существует";
            header("location: {$_SERVER["PHP_SELF"]}");
            die;
        }
        if ($password !== $password_repeat) {
            $_SESSION["error"] = "Пароли не совпадают";
            header("location: {$_SERVER["PHP_SELF"]}");
            die;
        }
        $db->add_user($email, $password);
        $_SESSION["success"] = "Регистрация прошла успешно";
        header("location: signin.php");
        die;
    }
}

// Check and SignIn
function signin($db): void
{
    if (!empty($_POST)) {
        $email = htmlspecialchars(trim($_POST["email"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        if (empty($email) || empty($password)) {
            $_SESSION["error"] = "Все поля должны быть заполнены";
            header("location: {$_SERVER["PHP_SELF"]}");
            die;
        }
        if (empty($db->exists_user($email)) || !password_verify($password, $db->get_user_pass($email))) {
            $_SESSION["error"] = "Введены неверные данные";
            header("location: {$_SERVER["PHP_SELF"]}");
            die;
        }
        $_SESSION["access"] = 1;
        $_SESSION["success"] = "Авторизация прошла успешно";
        header("location: index.php");
        die;
    }
}

//  Check and Add comment
function add_comment($db, $article_id): void
{
    if (!empty($_POST)) {
        $name = htmlspecialchars(trim($_POST["name_comment"]));
        $text = htmlspecialchars(trim($_POST["text_comment"]));
        if (empty($name) || empty($text)) {
            $_SESSION["error"] = "Все поля должны быть заполнены";
            header("location: {$_SERVER["REQUEST_URI"]}");
            die;
        }
        $db->add_comment($_POST["name_comment"], $_POST["text_comment"], $article_id);
        $_SESSION["success"] = "Комментарий добавлен";
        header("location: {$_SERVER["HTTP_REFERER"]}");
        die;
    }
}

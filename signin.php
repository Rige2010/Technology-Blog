<?php
session_start();
require_once "app/lib/functions.php";
require_once "app/class/Database.php";

$db = new Database();

page_access_check();
signin($db);

$title_name = "Авторизация";
require_once "app/default/header.php";

?>
<div class="container h-75 d-flex justify-content-center align-items-center" style="max-width: 300px;">
    <form class="w-100 row g-2 text-center mt-5" action="signin.php" method="POST">
        <h3 class="my-4">Авторизация</h3>
        <div class="col-md-12">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail4" name="email" />
        </div>
        <div class="col-md-12">
            <label for="inputPassword4" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="inputPassword4" name="password" />
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Войти</button>
        </div>
    </form>
</div>

<?php

require_once "app/default/footer.php";

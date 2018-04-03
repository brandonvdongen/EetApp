<?php
require_once "php/session.php";
require_once "classes/database.class.php";
require_once "classes/auth.class.php";

$database = new Database();
$auth = new Auth($database);

if (!$auth->verify_login()) {
    header('Location: php/login.php');
}

?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template</title>
    <script src="js/index.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js"
            integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <nav>
        <div class="nametag"><?= $auth->get_displayname() ?></div>
        <div class="menu_button"><i class="fas fa-bars"></i></div>
        <div class="menu">
<!--            <div class="button">-->
<!--                <a>home</a>-->
<!--            </div>-->
<!--            <div class="button">-->
<!--                <a>button2</a>-->
<!--            </div>-->
            <div class="button">
                <a href="php/logout.php">Logout</a>
                <i class="fas fa-sign-out-alt"></i></div>
        </div>
    </nav>
    <div class="body"></div>
</div>
</body>
</html>
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
</head>
<body>
<div class="container">
    <nav>
        <div class="menu_button"></div>
    </nav>
    <div class="body"></div>
</div>
</body>
</html>
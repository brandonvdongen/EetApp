<?php
require_once '../php/session.php';
require_once '../classes/database.class.php';
require_once '../classes/auth.class.php';

$database = new Database();
$auth = new Auth($database);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($auth->verify_login()) {
        header("location: ../index.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo print_r($_POST);
    if ($_POST["type"] === "login") {
        $result = $auth->login($_POST["username"], $_POST["password"]);
        if ($result->error) {
            echo $result->error;
        }
    } else if ($_POST["type"] === "register") {
        $user = $auth->add_user($_POST["username"]);
        print_r($user);
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="login.php" method="post" class="login">
    <input type="text" name="type" value="login" hidden>
    <label>
        <input type="text" name="username" required placeholder="username/email">
    </label>
    <label>
        <input type="password" name="password" required placeholder="password">
    </label>
    <input type="submit" value="submit">

</form>
<form action="login.php" method="post" class="login">
    <input type="text" name="type" value="register" hidden>
    <label>
        <input type="text" name="email" required placeholder="email">
        <input type="text" name="username" required placeholder="username">
    </label>
    <label>
        <input type="password" name="password" required placeholder="password">
    </label>
    <input type="submit" value="submit">

</form>
</body>
</html>

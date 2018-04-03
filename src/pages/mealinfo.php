<?php
if (isset($_GET["mealid"])) {
    $mealid = $_GET["mealid"];
    echo "weergeef maaltijd : " . $mealid;
} else {
    header('Location: index.php');
}


?>

<a href="index.php">Terug</a>

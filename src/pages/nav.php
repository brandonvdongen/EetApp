<link rel="stylesheet" href="css/nav.css">

<nav>
    <div class="nametag"><?= $auth->get_displayname() ?></div>
    <div class="menu_button"><i class="fas fa-bars"></i></div>
    <div class="menu">
        <div class="button">
            <a href="index.php">Home pagina</a>
            <i class="fas fa-home"></i>
        </div>
        <div class="button">
            <a href="index.php?page=addmeal">Nieuwe maaaltijd plaatsen</a>
            <i class="fas fa-plus-square"></i>
        </div>
        <div class="button">
            <a href="php/logout.php">Uitloggen</a>
            <i class="fas fa-sign-out-alt"></i></div>
    </div>
<!--    <div class="cover"></div>-->
</nav>
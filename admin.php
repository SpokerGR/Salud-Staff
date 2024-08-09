<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        header('Location: login.php');
    }

    if (isset($_SESSION['username']) && $_SESSION['username'] != 'Giannakis') {
        header('Location: index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salud | Staff</title>
        <link rel="stylesheet" href="style.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="icon" type="image/x-icon" href="img/icon.jpg">
    </head>
    <body>
        <!-- Header -->
        <header class="header">

            <a href="#home" class="logo"><span>Salud</span> | Espresso Boutique</a>
            <i class="bx bx-menu" id="menu-icon"></i>

            <nav class="menu">
                <a href="#home" class="active">Αρχική</a>
                <a href="#orders" class="">Παραγγελίες</a>
                <a href="order.php" class="">Πώληση</a>
                <a href="stock-add.php" class="">Απόθεμα</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </nav>
        </header>

        <!-- Home -->
        <section class="home" id="home">
            <div class="home-content">
                <div class="home-img">
                    <img src="/img/icon.jpg" alt="">
                </div>
                <h3>Καλώς ήρθες <span><?php echo($_SESSION['username']);?></span></h3>
            </div>
            <div class="trailer-layer">
            </div>
        </section>

        <script src="script.js"></script>
    </body>
</html>
<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        header('Location: login.php');
    }

    if (isset($_SESSION['username']) && $_SESSION['username'] != 'Giannakis') {
        header('Location: index.php');
        exit;
    }
    include("config.php");
    include("database.php");
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
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="script.js"></script>
    </head>
    <body>
        <!-- Header -->
        <header class="header">

            <a href="#home" class="logo"><span>Salud</span> | Espresso Boutique</a>
            <i class="bx bx-menu" id="menu-icon"></i>

            <nav class="menu">
                <a href="index.php" class="">Αρχική</a>
                <a href="orders.php" class="">Παραγγελίες</a>
                <a href="order.php" class="">Πώληση</a>
                <a href="" class="active">Απόθεμα</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </nav>
        </header>

        <!-- Form -->
        <section class="stock" id="stock">
            <h2 class="heading">Προσθήκη <span>Προϊόντος</span></h2>

            <form action="stock-remove.php" method="POST">
                <div class="input-box-remove">
                    <input type="text" id="product-name-remove" name="product-name" placeholder="Όνομα">
                </div>
                <button type="submit" name="submit" id="submit" class="btn">Προσθήκη</button>
                <button type="change" name="change" id="change" class="btn">Επεξεργασία</button>
                <button type="delete" name="delete" id="delete" class="btn">Αφαίρεση</button>
            </form>
        </section>

       <!-- Save to database -->


        <?php
                if(isset($_POST['delete']))
                {    
                    $product_name = $_POST['product-name'];
                
                    $sql = "DELETE FROM products WHERE product_name = '$product_name'";
                
                    $stmt = $conn->prepare($sql);
                    if (!$stmt) {
                        echo "Prepare failed: " . $conn->error;
                        exit;
                    }
                
                    $stmt->execute();
                
                    if ($stmt->error) {
                        echo "Error: " . $stmt->error;
                    } else {
                        echo '<script>swal("Το προϊόν διαγράφηκε", "", "success");</script>';
                    }
                    $stmt->close();
                    $conn->close();
                }else if(isset($_POST['submit']))
                {
                    header("Location: stock-add.php");
                    exit;
                } else if(isset($_POST['change']))
                {
                    header("Location: stock-change.php");
                    exit;
                } 
        ?>

        <script src="script.js"></script>
    </body>
</html>
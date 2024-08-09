<?php
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        header('Location: login.php');
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
                <a href="admin.php" class="">Αρχική</a>
                <a href="orders.php" class="">Παραγγελίες</a>
                <a href="" class="active">Καταχώρηση</a>
                <a href="stock-add.php" class="">Απόθεμα</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </nav>
        </header>

        <!-- Form -->
        
        <section class="stock" id="stock">
            <h2 class="heading">Καταχώρηση <span>Παραγγελίας</span></h2>

            <form action="stock-add.php" method="POST">
                <div class="input-box">
                    <input type="text" id="product-name" name="product-name" placeholder="Ονοματεπώνυμο">
                    <input type="text" id="product-price" name="product-price" placeholder="Διεύθηνση">
                    <input type="text" id="product-price" name="product-price" placeholder="Αριθμός">
                    <input type="text" id="product-qty" name="product-qty" placeholder="Περιοχή">
                    <input type="text" id="product-qty" name="product-qty" placeholder="Ταχυδρομικός Κώδικας"> 
                    <input type="text" id="product-info" name="product-info" placeholder="Πληροφορίες">
                </div>
                <button type="submit" name="submit" id="submit" class="btn">Προσθήκη</button>
            </form>
        </section>





       <!-- Save to database -->


        <?php
                if(isset($_POST['submit']))
                {    
                     $product_name = $_POST['product-name'];
                     $product_price = $_POST['product-price'];
                     $product_qty = $_POST['product-qty'];
                     $product_info = $_POST['product-info'];
                     $product_status = "Σε Απόθεμα";
                     $sql = "INSERT INTO products (product_name, product_price, product_qty, product_info, product_status) VALUES (?,?,?,?,?)";
                     $stmt = $conn->prepare($sql);
                     $stmt->bind_param("sdiss", $product_name, $product_price, $product_qty, $product_info, $product_status);
                     $stmt->execute();
                     if ($stmt->affected_rows > 0) {
                        echo '<script>swal("Το προϊόν προστέθηκε", "", "success");</script>';
                     } else {
                        echo "Error: " . $sql . ":-" . mysqli_error($sql);
                     }
                     $stmt->close();
                     $conn->close();
                } else if(isset($_POST['change']))
                {
                    header("Location: stock-change.php");
                    exit;
                } else if(isset($_POST['delete']))
                {
                    header("Location: stock-remove.php");
                    exit;
                } 
        ?>
    </body>
</html>
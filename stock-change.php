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
            <h2 class="heading">Επεξεργασία <span>Προϊόντος</span></h2>

            <form action="stock-change.php" method="POST">
                <div class="input-box">
                    <select name="product-name" id="product-name">
                        <option>Όνομα Προϊόντος</option>
                        <?php 
                            $query ="SELECT product_name FROM products";
                            $result = $conn->query($query);

                            if($result->num_rows> 0){
                                $options= mysqli_fetch_all($result, MYSQLI_ASSOC);
                            }
                            foreach ($options as $option) {
                        ?>
                                <option><?php echo $option['product_name']; ?> </option>
                                <?php 
                                    }
                                ?>  
                    </select>
                    <select name="product-status" id="product-status">
                        <option>Κατάσταση Προϊόντος</option>
                        <option>Σε Απόθεμα</option>
                        <option>Μερικό Απόθεμα</option>
                        <option>Ελειπής</option>
                    </select>
                    <input type="text" id="product-price" name="product-price" placeholder="Τιμή">
                    <input type="text" id="product-qty" name="product-qty" placeholder="Ποσότητα"> 
                </div>
                <div id="product-info-change">
                    <input type="text" id="product-info-change" name="product-info" placeholder="Πληροφορίες">
                </div>
                <button type="submit" name="submit" id="submit" class="btn">Προσθήκη</button>
                <button type="change" name="change" id="change" class="btn">Επεξεργασία</button>
                <button type="delete" name="delete" id="delete" class="btn">Αφαίρεση</button>
            </form>
        </section>

       <!-- Save to database -->


        <?php
            if(isset($_POST['change']))
            {    
                $product_name = $_POST['product-name'];
                $product_status = $_POST['product-status'];
                $product_price = $_POST['product-price'];
                $product_qty = $_POST['product-qty'];
                $product_info = $_POST['product-info'];
                $sql = "UPDATE products SET ";

                $update_fields = array();
                 
                if (!empty($product_status)) {
                    $update_fields[] = "product_status = '$product_status'";
                }
                 
                if (!empty($product_price)) {
                    $update_fields[] = "product_price = '$product_price'";
                }
                 
                if (!empty($product_qty)) {
                    $update_fields[] = "product_qty = '$product_qty'";
                }
                 
                if (!empty($product_info)) {
                    $update_fields[] = "product_info = '$product_info'";
                }
                 
                if (count($update_fields) > 0) {
                    $sql .= implode(", ", $update_fields);
                    $sql .= " WHERE product_name = '$product_name'";
                 
                    $stmt = $conn->prepare($sql);
                    if (!$stmt) {
                        echo "Prepare failed: " . $conn->error;
                        exit;
                    }
                 
                    $stmt->execute();
                 
                    if ($stmt->error) {
                        echo "Error: " . $stmt->error;
                    } else {
                        echo '<script>swal("Το προϊόν επεξεργάστηκε", "", "success");</script>';
                    }
                    $stmt->close();
                    $conn->close();
                } else {
                    echo '<script>swal("Δεν έγιναν αλλαγές", "", "info");</script>';
                }
            }else if(isset($_POST['submit']))
            {
                header("Location: stock-add.php");
                exit;
            } else if(isset($_POST['delete']))
            {
                header("Location: stock-remove.php");
                exit;
            } 
        ?>
    </body>
</html>
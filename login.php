<?php
    session_start();
    include("config.php");
    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salud | Espresso Boutique</title>
        <link rel="stylesheet" href="login_style.css">
        <link rel="icon" type="image/x-icon" href="img/icon.jpg">
        <script src="/js/script.js"></script>
    </head>
    <body>
        <form action="login.php" method="post">
            <h3>Salud Staff</h3>
    
            <label for="username">Username</label>
            <input type="text" placeholder="Username" id="username" name="username">
    
            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" name="password">
    
            <button id="submit" name="submit">Log In</button>
        </form>
        <?php
                if(isset($_POST['submit'])) {
                    $name = $_POST['username'];
                    $pass = $_POST['password'];

                    $query = "SELECT staff_username, staff_password FROM staff WHERE staff_username = '$name' AND staff_password = '$pass'";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['username'] = $name;
                        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
                        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                        if($name == "Giannakis"){
                            header('Location: admin.php');
                        } else {
                            header('Location: index.php');
                        }
                        exit;
                    } else {
                        $error = "Invalid username or password";
                    }
                }
                            
        ?>
    </body>
</html>
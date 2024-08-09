<?php

/**
 * Connect to the mysql database.
*/
if (!isset($_CONFIG))
    require 'config.php';

$conn=new mysqli ($CFG_SERVER, $CFG_USER, $CFG_PASSWORD)
or die ('Wrong!');

/* connect to database */
$selected = mysqli_select_db ($conn,$CFG_DATABASE);


?>


<?php
$username="root";
$password="123";
$database="easyfund_new";



// $connection = mysql_connect('localhost', $username, $password);

// $connection = mysqli_connect('localhost', $username, $password) or die ("could not connect");

// $db = mysqli_connect('localhost', $username, $password) or die ("could not connect");
$db = new mysqli('localhost', $username, $password, $database) or die ("could not connect");

// mysql_selectdb($database, $connection);
// mysqli_select_db($connection, $database);
// mysqli_select_db($db, $database);

?>
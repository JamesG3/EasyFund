<?php
$username="root";
$password="123";
$database="easyfund";



// $connection = mysql_connect('localhost', $username, $password);

$connection = mysqli_connect('localhost', $username, $password) or die ("could not connect");

// mysql_selectdb($database, $connection);
mysqli_select_db($connection, $database);

?>
<?php
session_start();
require 'db.php';


#echo $_POST["varname"];
$insert_follow= "INSERT into friendship (user1, user2) values ('{$_POST["varname"]}','{$_SESSION["uid"]}')";

if(mysqli_query($db, $insert_follow)) {
		// echo "Congratulations ";
		// echo ":  ";
  //   	echo "New record created successfully";
	}
else{
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
	}


header("Location:userpage.php?id={$_POST["varname"]}");


?>
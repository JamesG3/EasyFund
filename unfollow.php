<?php
session_start();
require 'db.php';


#echo $_POST["varname"];
// $delete_follow = "Delete from friendship where user1 = '{$_POST["varname"]}' and '{$_SESSION["uid"]}'";

// if(mysqli_query($db, $delete_follow)) {
// 		// echo "Congratulations ";
// 		// echo ":  ";
//   //   	echo "New record created successfully";
// 	}
// else{
//     echo "Error: " . $sql . "<br>" . mysqli_error($db);
// 	}

$varname = $_POST["varname"];
$uid = $_SESSION["uid"];


	$insert_follow = $db->prepare("DELETE from friendship where user1 = ? and user2 = ?");
    $insert_follow->bind_param("ii", $varname, $uid);
    $insert_follow->execute();	


header("Location:userpage.php?id={$_POST["varname"]}");


?>




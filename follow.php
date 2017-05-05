<?php
session_start();
require 'db.php';


#echo $_POST["varname"];
$varname = $_POST["varname"];
$uid = $_SESSION["uid"];


// $insert_follow= "INSERT into friendship (user1, user2) values ('{$_POST["varname"]}','{$_SESSION["uid"]}')";

// if(mysqli_query($db, $insert_follow)) {
// 		// echo "Congratulations ";
// 		// echo ":  ";
//   //   	echo "New record created successfully";
// 	}
// else{
//     echo "Error: " . $sql . "<br>" . mysqli_error($db);
// 	}

	$insert_follow = $db->prepare("INSERT INTO friendship (`user1`, `user2`) VALUES (?,?)");
    $insert_follow->bind_param("ii", $varname, $uid);
    $insert_follow->execute();	

header("Location:userpage.php?id={$_POST["varname"]}");


?>
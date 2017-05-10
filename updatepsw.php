<?php
session_start();

if (isset($_SESSION['uid'])){
	require 'style.php';
	$uid = $_SESSION['uid'];
	#$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
	require 'db.php';


	#$query = "SELECT * FROM user where uid = '$uid'";
	#$res = $db->query($query);


	$query = $db->prepare("SELECT * FROM user where uid = ?");
    $query->bind_param("i", $uid);
    $query->execute();
    $res = $query->get_result();


	if (!$res){
   	echo "Something wrong!!";
   	showerror();				# if query faild, show error message.
   	}

	?>
	<html>
	<body>
<script type="text/javascript">
    function back_to_me(){
        window.location.href = "mainpage.php";
    }
</script>
  		<input id = 'back' type='submit' value='back to my page' onClick='back_to_me()';>

	<h1 align = "center">update my password</h1>

	<form method="POST" action="update_psw.php">
	<table cellspacing="20" align=center>

	<tr>
		<td><strong>old password:</strong></td>
		<td> <input type="password" size="20" name="opsw" required></td>
	</tr>
	<tr>
		<td><strong>new password:</strong></td>
		<td><input type="password" size="20" name="npsw1" required></td>
	</tr>
	<tr>
		<td><strong>new password:</br>(enter again)</strong></td>
		<td><input type="password" size="20" name="npsw2" required></td>
	</tr>
	
	</table>
	<p align=center><input type="submit" value="update!">
	</form>
	</body>
		</html>
	<?php

	}


else{
		echo "Dude you are not authorized to access this page!";
	}


?>
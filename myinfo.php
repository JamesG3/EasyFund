<?php
session_start();

if (isset($_SESSION['uid'])){
	$uid = $_SESSION['uid'];
	#$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
	require 'db.php';
	$query = "SELECT * FROM user where uid = '$uid'";
	$res = $db->query($query);

	if (!$res){
   	echo "Something wrong!!";
   	showerror();				# if query faild, show error message.
   	}

	?>
	<html>
	<body>
		<h2>Hi <?php echo $_SESSION['uid'] ?>

	<form method="POST" action="my_info.php">
	<table cellspacing="20" align=center>

	<?php

	while ($row = $res->fetch_assoc()){
    #echo "{$row['pname']} <br/>";
    #}
	#while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
	#foreach($line as $h){
	#	echo $h;
	#	echo '&nbsp&nbsp&nbsp&nbsp';
	#}
	?>

	<tr>
		<td><strong>username:</strong></td>
		<td> <input type="text" size="20" name="uname" value = <?php echo "{$row['username']}" ?> ></td>
	</tr>
	<tr>
		<td><strong>email:</strong></td>
		<td><input type="text" size="20" name="email" value = <?php echo "{$row['email']}" ?> ></td>
	</tr>
	<tr>
		<td><strong>hometown:</strong></td>
		<td> <input type="text" size="20" name="hometown" value = <?php echo "{$row['hometown']}" ?> > </td>

	</tr>
	<tr>
		<td><strong>creditcard:</strong></td>
		<td> <input type="text" size="20" name="creditcard" value = <?php echo "{$row['creditcard']}" ?> > </td>
	</tr>
	<tr>
		<td><strong>password:</strong></td>
		<td> <input type="text" size="20" name="psw" value = <?php echo "{$row['password']}" ?> > </td>
	</tr>
	<tr>
		<td><strong>interests:</strong></td>
		<td> <input type="text" size="20" name="interests" value = <?php echo "{$row['interests']}" ?> > </td>
	</tr>
	<tr>
		
	</tr>
	<?php
	}
	?>
	
	</table>
	<p align=center><input type="submit" value="save">
	</form>
	</body>
		</html>
	<?php

	}


else{
		echo "Dude you are not authorized to access this page!";
	}


?>
<?php
session_start();

require 'db.php';
require 'js_functions.html';

date_default_timezone_set('America/New_York');


echo "test:    ";
echo $_GET["category"];
echo $_SESSION["uid"];

?>

<!DOCTYPE html>


<html>
<head>
	<title>MainPage</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
<body>


<?php




	$search_query = "SELECT *  FROM project  where category = '{$_GET["category"]}'";
	$search_result = mysqli_query($db,$search_query);


		echo "<table border ='1'>
		<th>Projects List</th>
		<tr>
		<th>Project ID</th>
		<th>Project Name</th>
		<th>Min amount</th>
		<th>Max amount</th>
		<th>Owner ID</th>
		<th>fund Deadline</th>
		<th>Project DeadLine</th>
		<th>Category</th>
		<th>Tags</th>
		<th>Description</th>
		<th>Details</th>
		</tr>";

	while($row = mysqli_fetch_array($search_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . $row['pname'] . "</td>";
    		echo "<td>" . $row['minamount'] . "</td>";
    		echo "<td>" . $row['maxamount'] . "</td>";

    		echo "<td>" . $row['uid'] . "</td>";
    		// echo '<td><a href="userpage.php?id='.$row['uid'].'">'.$row['uid'].'</a></td>';
    		echo "<td>" . $row['fundDdl'] . "</td>";
    		echo "<td>" . $row['projDdl'] . "</td>";
    		echo "<td>" . $row['category'] . "</td>";
    		echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>" . $row['description'] . "</td>";
    		echo "<td><input type='submit' value='See Details' onClick='detailed_projects(this)';></td>";
    		echo "</tr>";

	}; 


	$currenttime = date('Y-m-d H:i:s');
	$insert_tag = "INSERT into tagHistory (uid, tag, searchTagTime) values ('{$_SESSION["uid"]}', '{$_GET["category"]}', '$currenttime')";

	if(mysqli_query($db, $insert_tag)) {
		echo "Congratulations ";
		echo ":  ";
    	echo "New record created successfully";
		}
	else{
    	echo "Error: " . $sql . "<br>" . mysqli_error($db);
		}

?>

	
</body>
</html>
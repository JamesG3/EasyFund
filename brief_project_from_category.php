<?php
session_start();

require 'db.php';
require 'js_functions.html';

date_default_timezone_set('America/New_York');


// echo "test:    ";
// echo $_GET["category"];
// echo $_SESSION["uid"];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

		<script type="text/javascript">

		function back_to_me(){

  			window.location.href = "mainpage.php";
		}



	</script>

<style type="text/css">
	caption {
    text-align: center;
    /*margin-bottom: 5px;*/
    /*margin-left: 10px;*/
    /*text-transform: lowercase;*/
    font-size: 140%;
    padding: 5px;
    /*letter-spacing: 10px;*/
    font-weight: bold;
	}
	table{
		margin: 0 auto;
		margin-bottom: 20px;
		border:1px solid #000;
	}
	td{
		text-align:center; 
		border: none;
		max-width: 200px;

	}
	#back {
		/*float: left;*/
		margin-left: 15px;
		margin-top: 10px;
		margin-bottom: 20px;
	}


</style>
</head>
<body>

</body>
</html>


<?php

if(!$_SESSION["uid"]){
	echo "You are not allow to access this page after log-out";
	exit();
}

$category = $_GET["category"];
$uid = $_SESSION["uid"];


	echo "<input id = 'back' type='submit' value='back to my page' onClick='back_to_me()';>";

	// $search_query = "SELECT *  FROM project  where category = '{$_GET["category"]}'";
	// $search_result = mysqli_query($db,$search_query);

	$search_query = $db->prepare("SELECT *  FROM project  where category = ? ");
    $search_query->bind_param("s",$category);
    $search_query->execute();
    $search_result = $search_query->get_result();


		echo "<table>
		<caption>Projects List</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner ID</th>
		<th>fund Deadline</th>
		<th>Category</th>
		<th>Tags</th>
		</tr>";
if($search_result){

	while($row = mysqli_fetch_array($search_result))
	{
			echo "<tr>";
    		#echo "<td>" . $row['pid'] . "</td>";
    		#echo "<td>" . $row['pname'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.$row['pid'].'">'.$row['pname'].'</a></td>';
    		#echo "<td>" . $row['minamount'] . "</td>";
    		#echo "<td>" . $row['maxamount'] . "</td>";

    		#echo "<td>" . $row['uid'] . "</td>";
    		echo '<td><a href="userpage.php?id='.$row['uid'].'">'.$row['uid'].'</a></td>';
    		echo "<td>" . $row['fundDdl'] . "</td>";
    		// echo '<td><a href="userpage.php?id='.$row['uid'].'">'.$row['uid'].'</a></td>';
    		#echo "<td>" . $row['fundDdl'] . "</td>";
    		#echo "<td>" . $row['projDdl'] . "</td>";
    		#echo "<td>" . $row['category'] . "</td>";
    		#echo "<td>" . $row['tags'] . "</td>";
    		echo '<td><a href="brief_project_from_category.php?category='.$row['category'].'">'.$row['category'].'</a></td>';

    		#echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>";

			$tagsArray = explode(',', $row['tags']);
			foreach($tagsArray as $tag) {
    			#echo $tag.' '; // print each link etc
    			echo '<a href="brief_project_from_tag.php?tag='.$tag.'">'.$tag.'</a>';
    			echo "  ";
			}
			echo "</td>";

    		#echo "<td>" . $row['description'] . "</td>";
    		// echo "<td><input type='submit' value='See Details' onClick='detailed_projects(this)';></td>";
    		echo "</tr>";

	};
} 


	$currenttime = date('Y-m-d H:i:s');
	// $insert_tag = "INSERT into tagHistory (uid, tag, searchTagTime) values ('{$_SESSION["uid"]}', '{$_GET["category"]}', '$currenttime')";

      $insert_tag = $db->prepare("INSERT INTO tagHistory (`uid`, `tag`, `searchTagTime`) VALUES (?,?,?)");
      $insert_tag->bind_param("iss", $uid, $category, $currenttime);
      $insert_tag->execute();	

	// if(mysqli_query($db, $insert_tag)) {
	// 	// echo "Congratulations ";
	// 	// echo ":  ";
 //  //   	echo "New record created successfully";
	// 	}
	// else{
 //    	echo "Error: " . $sql . "<br>" . mysqli_error($db);
	// 	}
    echo $insert_tag->error; //to check errors
	$insert_tag->close();
?>


<?php
require 'db.php';
session_start();
?>

<!DOCTYPE html>


<html>
<head>
	<title>MainPage</title>
<script type="text/javascript">
	function add(){
		header("Location: index.html");
	}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
<body>



<?php



if(isset($_SESSION["uid"])){
	echo "Welcome: ID ";
	echo $_SESSION["uid"];
	echo "<br>";
	echo "<br>";

/*************************************************
1) Recent Proeject List
**************************************************/

	$recentproject_query = "SELECT *  from project where uid in (  select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	// $recentproject_query = "SELECT *  from project where uid = {$_SESSION["uid"]}";
	$recentproject_result = mysqli_query($db,$recentproject_query);


	// echo "check!";
	// $prow = mysqli_fetch_array($recentproject_result);

	// if (!$prow) {
	//     printf("Error: %s\n", mysqli_error($db));
	//    	exit();
	// }

	// $rowcount=mysqli_num_rows($recentproject_result);
	// echo "count:";
	// echo $rowcount;


		#echo "<h2 align='center'>Recent Project List</h2>";
		echo "<table border ='1'>
		<th>Recent Projects List</th>
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
		</tr>";

	while($row = mysqli_fetch_array($recentproject_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . $row['pname'] . "</td>";
    		echo "<td>" . $row['minamount'] . "</td>";
    		echo "<td>" . $row['maxamount'] . "</td>";
    		echo "<td>" . $row['uid'] . "</td>";
    		echo "<td>" . $row['fundDdl'] . "</td>";
    		echo "<td>" . $row['projDdl'] . "</td>";
    		echo "<td>" . $row['category'] . "</td>";
    		echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>" . $row['description'] . "</td>";
    		echo "</tr>";

	}; 



/**************************************************
2) Recent Comments
**************************************************/

	$recentcomment_query = "SELECT *  from comment where uid in (  select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	// $recentproject_query = "SELECT *  from project where uid = {$_SESSION["uid"]}";
	$recentcomment_result = mysqli_query($db,$recentcomment_query);



		echo "<table border ='1'>
		<th>Recent Comments</th>
		<tr>
		<th>Project ID</th>
		<th>User ID</th>
		<th>Post Time</th>
		<th>Comments</th>
		</tr>";

	while($row = mysqli_fetch_array($recentcomment_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . $row['uid'] . "</td>";
    		echo "<td>" . $row['posttime'] . "</td>";
    		echo "<td>" . $row['comm'] . "</td>";
    		echo "</tr>";

	}; 


/**************************************************
3) Recent Pledges
**************************************************/

	$recentpledges_query = "SELECT *  from fund where uid in (  select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	$recentpledges_result = mysqli_query($db,$recentpledges_query);



		echo "<table border ='1'>
		<th>Recent Pledges</th>
		<tr>
		<th>Fund ID</th>
		<th>User ID</th>
		<th>Project ID</th>
		<th>Fund amount</th>
		<th>Fund state</th>
		<th>Charge Time</th>
		</tr>";

	while($row = mysqli_fetch_array($recentpledges_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['fid'] . "</td>";
    		echo "<td>" . $row['uid'] . "</td>";
    		echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . $row['famount'] . "</td>";
    		echo "<td>" . $row['fstate'] . "</td>";
    		echo "<td>" . $row['chargeTime'] . "</td>";
    		echo "</tr>";

	}; 


/**************************************************
4) Recent Likes
**************************************************/


	$recentLike_query = "SELECT project.pid  as ppid,pname,minamount,maxamount,project.uid as puid,fundDdl, projDdl, category, tags, description, likePj.uid as luid  from project right join likePj on project.pid = likePj.pid where likePj.uid in ( select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	$recentLike_result = mysqli_query($db,$recentLike_query);


		echo "<table border ='1'>
		<th>Recent Likes</th>
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
		<th>Like By</th>
		</tr>";

	while($row = mysqli_fetch_array($recentLike_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['ppid'] . "</td>";
    		echo "<td>" . $row['pname'] . "</td>";
    		echo "<td>" . $row['minamount'] . "</td>";
    		echo "<td>" . $row['maxamount'] . "</td>";
    		echo "<td>" . $row['puid'] . "</td>";
    		echo "<td>" . $row['fundDdl'] . "</td>";
    		echo "<td>" . $row['projDdl'] . "</td>";
    		echo "<td>" . $row['category'] . "</td>";
    		echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>" . $row['description'] . "</td>";
    		echo "<td>" . $row['luid'] . "</td>";
    		echo "</tr>";

	};


/**************************************************
5) My Pledge
**************************************************/


	$mypledges_query = "SELECT *  from fund where uid ={$_SESSION["uid"]}";
	$mypledges_result = mysqli_query($db,$mypledges_query);

		echo "<table border ='1'>
		<th>My Pledges</th>
		<tr>
		<th>Fund ID</th>
		<th>User ID</th>
		<th>Project ID</th>
		<th>Fund amount</th>
		<th>Fund state</th>
		<th>Charge Time</th>
		</tr>";

	while($row = mysqli_fetch_array($mypledges_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['fid'] . "</td>";
    		echo "<td>" . $row['uid'] . "</td>";
    		echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . $row['famount'] . "</td>";
    		echo "<td>" . $row['fstate'] . "</td>";
    		echo "<td>" . $row['chargeTime'] . "</td>";
    		echo "</tr>";

	}; 



/**************************************************
6) My Pledge rate
**************************************************/
	$mypledgesrate_query = "SELECT *  from sponRate where uid ={$_SESSION["uid"]}";
	$mypledgesrate_result = mysqli_query($db,$mypledgesrate_query);

		echo "<table border ='1'>
		<th>My Rate</th>
		<tr>
		<th>Project ID</th>
		<th>Stars</th>
		<th>Review</th>
		<th>Rate Time</th>
		<th>Owner's feedback</th>
		</tr>";

	while($row = mysqli_fetch_array($mypledgesrate_result))
	{
			echo "<tr>";
    		echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . $row['star'] . "</td>";
    		echo "<td>" . $row['review'] . "</td>";
    		echo "<td>" . $row['ratetime'] . "</td>";
    		echo "<td>" . $row['owner_review'] . "</td>";
    		echo "</tr>";

	}; 


/**************************************************
7) recommend
**************************************************/

}








?>






</body>
</html>

















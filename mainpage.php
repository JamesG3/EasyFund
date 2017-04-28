<?php
require 'db.php';
session_start();

echo "<input type='submit' value='edit profile' onClick='edit_prof()';>";
echo "<input type='submit' value='create project' onClick='create_proj()';>";
echo "<input type='submit' value='logout' onClick='logout()';>";
echo "<input type='text' name='search_text' value=''>";
echo "<input type='submit' value='search' onClick='search()';>";



echo "<br>";
echo "<br>";

?>

<!DOCTYPE html>


<html>
<head>
	<title>MainPage</title>
<!-- <script type="text/javascript">
	function add(){
		header("Location: index.html");
	}
</script> -->


	<script type="text/javascript">
		function logout(){

			<?php session_destroy(); ?>

  			window.location.href = "index.php";
		}
		function edit_prof(){

  			window.location.href = "myinfo.php";
		}
		function create_proj(){

  			window.location.href = "projPost.php";
		}
		function search(){

  			window.location.href = "index.php";
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
	$recentproject_result = mysqli_query($connection,$recentproject_query);


	// echo "check!";
	// $prow = mysqli_fetch_array($recentproject_result);

	// if (!$prow) {
	//     printf("Error: %s\n", mysqli_error($connection));
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

	$recentcomment_result = mysqli_query($connection,$recentcomment_query);



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
	$recentpledges_result = mysqli_query($connection,$recentpledges_query);



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
	$recentLike_result = mysqli_query($connection,$recentLike_query);


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
	$mypledges_result = mysqli_query($connection,$mypledges_query);

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
	$mypledgesrate_result = mysqli_query($connection,$mypledgesrate_query);

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
	$rec_keyword_query = "SELECT keyword  from keywordHistory where uid ={$_SESSION["uid"]}";
	$rec_keyword_result = mysqli_query($connection,$rec_keyword_query);

	// $rowcount=mysqli_num_rows($rec_result);
	// echo "count:";
	// echo $rowcount;

	while($row = mysqli_fetch_array($rec_keyword_result)){
		#echo $row['keyword'];

		$likes .= $row['keyword']. "|";

	}
	#$new_like = rtrim($likes,"| ");
	#echo $likes;
	#echo $new_like;

	$rec_tag_query = "SELECT tag  from tagHistory where uid ={$_SESSION["uid"]}";
	$rec_tag_result = mysqli_query($connection,$rec_tag_query);



	while($row = mysqli_fetch_array($rec_tag_result)){
		#echo $row['keyword'];

		$likes .= $row['tag']. "|";

	}
	$new_like = rtrim($likes,"| ");
	#echo $new_like;


	$rec_query = "SELECT * from project where (pname REGEXP '$new_like'  or category REGEXP '$new_like' or tags REGEXP '$new_like' or description REGEXP '$new_like' ) and pjstate='incomplete'";
	$rec_result = mysqli_query($connection,$rec_query);

	// $rowcount=mysqli_num_rows($rec_result);
	// echo "count:";
	// echo $rowcount;

		echo "<table border ='1'>
		<th>Recommend List</th>
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

	while($row = mysqli_fetch_array($rec_result))
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



}









?>






</body>
</html>

















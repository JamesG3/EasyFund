<?php
session_start();
// echo "userpage test";
// echo $_GET["id"];
require 'db.php';

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
	form {
		margin-left: 15px;
	}


</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
<body>



<?php

if(!$_SESSION["uid"]){
	echo "You are not allow to access this page after log-out";

	exit();
}


if(isset($_GET["id"])){
	// echo "Welcome to ID ";
	// echo $_GET["id"];
	// echo "'page";
	// echo "<br>";
	// echo "<br>";

	$uid = $_SESSION["uid"];
	$id = $_GET["id"];

	// $query = "SELECT username FROM user where uid = '{$_GET["id"]}'";
	// $res = $db->query($query);

	// if (!$res){
 //   	echo "Something wrong!!";
 //   	showerror();				# if query faild, show error message.
 //   	}

 //   	while ($row = $res->fetch_assoc()){
 //    $username = $row['username'];
 //    }

	$query = $db->prepare("SELECT username FROM user where uid = ?");
	$query->bind_param("i", $id);
	$query->execute();

	$query->bind_result($row);
	$query->fetch();
	#echo $row;

	if (!$row){
   	echo "Something wrong!!";
   	showerror();				# if query faild, show error message.
   	}

   	$username = $row;

$query->close();
    echo "<h2>Welcome to  ".$username."'s Page</h2>" ;

echo "<input id = 'back' type='submit' value='back to my page' onClick='back_to_me()';>";





	$follow_query = $db->prepare("SELECT * from friendship where user1 = ? and user2 = ?");
    $follow_query->bind_param("ii",$id,$uid);
    $follow_query->execute();
    $follow_result = $follow_query->get_result();


// $follow_query = "SELECT * from friendship where user1 = '{$_GET["id"]}' and user2 = '{$_SESSION['uid']}'";

// $follow_result = mysqli_query($db,$follow_query);

// echo $_GET['id'];
// echo $_SESSION['uid'];

$rowcount=mysqli_num_rows($follow_result);
// echo "count:";
// echo $rowcount;

if($rowcount == 0){
	// echo "<input id = 'back' type='submit' value='follow' onClick='follow()';>";
	echo "<form method='POST' action='follow.php'>";
	echo "<input type='hidden' name='varname' value= '{$_GET["id"]}' >";
	echo "<input id = 'searchs' type='submit' value='follow'>";
	echo "</form>";
}
if($rowcount != 0){
	echo "<form method='POST' action='unfollow.php'>";
	echo "<input type='hidden' name='varname' value= '{$_GET["id"]}' >";
	echo "<input id = 'searchs' type='submit' value='unfollow'>";
	echo "</form>";
}


/*************************************************
1) Recent Proeject List
**************************************************/

	// $recentproject_query = "SELECT *  from project where uid in (  select user1 from friendship where user2 = {$_GET["id"]} )";
	// // $recentproject_query = "SELECT *  from project where uid = {$_SESSION["uid"]}";
	// $recentproject_result = mysqli_query($db,$recentproject_query);

	$recentproject_query = $db->prepare("SELECT *  from project natural join user where uid in (  select user1 from friendship where user2 = ? )");
    $recentproject_query->bind_param("i",$id);
    $recentproject_query->execute();
    $recentproject_result = $recentproject_query->get_result();


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
		// echo "<table border ='1'>
		// <th>Recent Projects List</th>
		// <tr>
		// <th>Project ID</th>
		// <th>Project Name</th>
		// <th>Min amount</th>
		// <th>Max amount</th>
		// <th>Owner ID</th>
		// <th>fund Deadline</th>
		// <th>Project DeadLine</th>
		// <th>Category</th>
		// <th>Tags</th>
		// <th>Description</th>
		// </tr>";
		echo "<table>
		<caption>Recent Projects List</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>fund Deadline</th>
		<th>Category</th>
		<th>Tags</th>
		</tr>";

if($recentproject_result){

	while($row = mysqli_fetch_array($recentproject_result))
	{



			echo "<tr>";
    		#echo "<td>" . $row['pid'] . "</td>";
    		#echo "<td>" . $row['pname'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['pid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		#echo "<td>" . $row['minamount'] . "</td>";
    		#echo "<td>" . $row['maxamount'] . "</td>";

    		#echo "<td>" . $row['uid'] . "</td>";
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['uid']).'">'.htmlspecialchars($row['username']).'</a></td>';
    		echo "<td>" . htmlspecialchars($row['fundDdl']) . "</td>";
    		#echo "<td>" . $row['projDdl'] . "</td>";
    		#echo "<td>" . $row['category'] . "</td>";
    		echo '<td><a href="brief_project_from_category.php?category='.htmlspecialchars($row['category']).'">'.htmlspecialchars($row['category']).'</a></td>';

    		#echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>";

			$tagsArray = explode(',', htmlspecialchars($row['tags']));
			foreach($tagsArray as $tag) {
    			#echo $tag.' '; // print each link etc
    			echo '<a href="brief_project_from_tag.php?tag='.htmlspecialchars($tag).'">'.htmlspecialchars($tag).'</a>';
    			echo "  ";
			}
			echo "</td>";

    		#echo "<td>" . $row['description'] . "</td>";
    		echo "</tr>";

	}; 
}

$recentproject_query->close();

/**************************************************
2) Recent Comments
**************************************************/

	// $recentcomment_query = "SELECT project.pid as ppid, pname, project.uid as ouid, category, tags, posttime, comm, comment.uid as cuid from project right join comment on project.pid = comment.pid where comment.uid in ( select user1 from friendship where user2 = {$_GET["id"]}  )";

	// $recentcomment_result = mysqli_query($db,$recentcomment_query);

	$recentcomment_query = $db->prepare("SELECT project.pid as ppid, pname, project.uid as ouid,u1.username as oname, category, tags, posttime, comm, comment.uid as cuid, u2.username as cname from project, comment,user u1,user u2 where project.pid = comment.pid and project.uid = u1.uid and comment.uid  = u2.uid and comment.uid in ( select user1 from friendship where user2 = ?  )");
    $recentcomment_query->bind_param("i",$id);
    $recentcomment_query->execute();
    $recentcomment_result = $recentcomment_query->get_result();



		echo "<table>
		<caption>Recent Comments</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>Category</th>
		<th>Tags</th>
		<th>Post Time</th>
		<th>Comments</th>
		<th>Commented By</th>
		</tr>";

if($recentcomment_result){

	while($row = mysqli_fetch_array($recentcomment_result))
	{
			echo "<tr>";
    		#echo "<td>" . $row['pname'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['ppid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		#echo "<td>" . $row['uid'] . "</td>";
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['ouid']).'">'.htmlspecialchars($row['oname']).'</a></td>';
    		echo '<td><a href="brief_project_from_category.php?category='.htmlspecialchars($row['category']).'">'.htmlspecialchars($row['category']).'</a></td>';
    		#echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>";

			$tagsArray = explode(',', htmlspecialchars($row['tags']));
			foreach($tagsArray as $tag) {
    			#echo $tag.' '; // print each link etc
    			echo '<a href="brief_project_from_tag.php?tag='.htmlspecialchars($tag).'">'.htmlspecialchars($tag).'</a>';
    			echo "  ";
			}
			echo "</td>";
    		echo "<td>" . htmlspecialchars($row['posttime']) . "</td>";
    		echo "<td>" . htmlspecialchars($row['comm']) . "</td>";
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['cuid']).'">'.htmlspecialchars($row['cname']).'</a></td>';
    		echo "</tr>";

	}; 
} 

$recentcomment_query->close();
/**************************************************
3) Recent Pledges
**************************************************/

	// $recentpledges_query = "SELECT project.pid as ppid, pname, fund.uid as fuid, famount, fstate from project right join fund on project.pid = fund.pid where fund.uid in ( select user1 from friendship where user2 = {$_GET["id"]} )";

	// // $recentpledges_query = "SELECT *  from fund where uid in (  select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	// $recentpledges_result = mysqli_query($db,$recentpledges_query);

	$recentpledges_query = $db->prepare("SELECT project.pid as ppid, pname, username, fund.uid as fuid, famount, fstate from project natural join user right join fund on project.pid = fund.pid where fund.uid in ( select user1 from friendship where user2 = ? )");
    $recentpledges_query->bind_param("i",$id);
    $recentpledges_query->execute();
    $recentpledges_result = $recentpledges_query->get_result();



		echo "<table>
		<caption>Recent Pledges</caption>
		<tr>
		<th>Project Name</th>
		<th>Pledger Name</th>
		<th>Fund amount</th>
		<th>Fund state</th>
		</tr>";

if($recentpledges_result){
	while($row = mysqli_fetch_array($recentpledges_result))
	{
			echo "<tr>";
    		#echo "<td>" . $row['fid'] . "</td>";
    		#echo "<td>" . $row['uid'] . "</td>";
    		
    		#echo "<td>" . $row['pid'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['ppid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['fuid']).'">'.htmlspecialchars($row['username']).'</a></td>';
    		echo "<td>" . htmlspecialchars($row['famount']) . "</td>";
    		echo "<td>" . htmlspecialchars($row['fstate']) . "</td>";
    		#echo "<td>" . $row['chargeTime'] . "</td>";
    		echo "</tr>";

	};
} 

$recentpledges_query->close();
/**************************************************
4) Recent Likes
**************************************************/


	// $recentLike_query = "SELECT project.pid  as ppid,pname,minamount,maxamount,project.uid as puid,fundDdl, projDdl, category, tags, description, likePj.uid as luid  from project right join likePj on project.pid = likePj.pid where likePj.uid in ( select user1 from friendship where user2 = {$_GET["id"]} )";
	// $recentLike_result = mysqli_query($db,$recentLike_query);
	$recentLike_query = $db->prepare("SELECT project.pid  as ppid,pname,minamount,maxamount,project.uid as puid,u1.username as oname, fundDdl, projDdl, category, tags, description, likePj.uid as luid , u2.username as lname from project,likePj, user u1, user u2 where project.pid = likePj.pid and project.uid = u1.uid and likePj.uid = u2.uid and likePj.uid in ( select user1 from friendship where user2 = ? )");
    $recentLike_query->bind_param("i",$id);
    $recentLike_query->execute();
    $recentLike_result = $recentLike_query->get_result();


		echo "<table>
		<caption>Recent Likes</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>Fund Deadline</th>
		<th>Category</th>
		<th>Tags</th>
		<th>Like By</th>
		</tr>";
if($recentLike_result){

	while($row = mysqli_fetch_array($recentLike_result))
	{
			echo "<tr>";
    		#echo "<td>" . $row['ppid'] . "</td>";
    		#echo "<td>" . $row['pname'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['ppid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		#echo "<td>" . $row['minamount'] . "</td>";
    		#echo "<td>" . $row['maxamount'] . "</td>";
    		#echo "<td>" . $row['puid'] . "</td>";
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['puid']).'">'.htmlspecialchars($row['oname']).'</a></td>';
    		echo "<td>" . $row['fundDdl'] . "</td>";
    		#echo "<td>" . $row['projDdl'] . "</td>";
    		#echo "<td>" . $row['category'] . "</td>";
    		echo '<td><a href="brief_project_from_category.php?category='.htmlspecialchars($row['category']).'">'.htmlspecialchars($row['category']).'</a></td>';
    		#echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>";

			$tagsArray = explode(',', htmlspecialchars($row['tags']));
			foreach($tagsArray as $tag) {
    			#echo $tag.' '; // print each link etc
    			echo '<a href="brief_project_from_tag.php?tag='.htmlspecialchars($tag).'">'.htmlspecialchars($tag).'</a>';
    			echo "  ";
			}
			echo "</td>";
    		#echo "<td>" . $row['description'] . "</td>";
    		#echo "<td>" . $row['luid'] . "</td>";
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['luid']).'">'.htmlspecialchars($row['lname']).'</a></td>';
    		echo "</tr>";

	};
}
$recentLike_query->close();
/**************************************************
4.5) My Project
**************************************************/

// $myproject_query = "SELECT *  from project where uid = {$_GET["id"]} ";

// $myproject_result = mysqli_query($db,$myproject_query);
	$myproject_query = $db->prepare("SELECT *  from project natural join user where uid = ? ");
    $myproject_query->bind_param("i",$id);
    $myproject_query->execute();
    $myproject_result = $myproject_query->get_result();

		echo "<table>
		<caption>".$username."'s Projects List</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>fund Deadline</th>
		<th>Category</th>
		<th>Tags</th>
		</tr>";

if($myproject_result){

	while($row = mysqli_fetch_array($myproject_result))
	{



			echo "<tr>";
    		#echo "<td>" . $row['pid'] . "</td>";
    		#echo "<td>" . $row['pname'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['pid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		#echo "<td>" . $row['minamount'] . "</td>";
    		#echo "<td>" . $row['maxamount'] . "</td>";

    		#echo "<td>" . $row['uid'] . "</td>";
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['uid']).'">'.htmlspecialchars($row['username']).'</a></td>';
    		echo "<td>" . $row['fundDdl'] . "</td>";
    		#echo "<td>" . $row['projDdl'] . "</td>";
    		#echo "<td>" . $row['category'] . "</td>";
    		echo '<td><a href="brief_project_from_category.php?category='.htmlspecialchars($row['category']).'">'.htmlspecialchars($row['category']).'</a></td>';

    		#echo "<td>" . $row['tags'] . "</td>";
    		echo "<td>";

			$tagsArray = explode(',', htmlspecialchars($row['tags']));
			foreach($tagsArray as $tag) {
    			#echo $tag.' '; // print each link etc
    			echo '<a href="brief_project_from_tag.php?tag='.htmlspecialchars($tag).'">'.htmlspecialchars($tag).'</a>';
    			echo "  ";
			}
			echo "</td>";

    		#echo "<td>" . $row['description'] . "</td>";
    		echo "</tr>";

	}; 
}
$myproject_query->close();
/**************************************************
5) My Pledge
**************************************************/


	// $mypledges_query = "SELECT project.pid as ppid, pname, project.uid as ouid, famount, fstate, chargeTime from project right join fund on project.pid = fund.pid where fund.uid ={$_GET["id"]}";



	// // $mypledges_query = "SELECT *  from fund where uid ={$_SESSION["uid"]}";
	// $mypledges_result = mysqli_query($db,$mypledges_query);

	$mypledges_query = $db->prepare("SELECT project.pid as ppid, pname, username, project.uid as ouid, famount, fstate, chargeTime from project natural join user right join fund on project.pid = fund.pid where fund.uid =?");
    $mypledges_query->bind_param("i",$id);
    $mypledges_query->execute();
    $mypledges_result = $mypledges_query->get_result();

		echo "<table>
		<caption>".$username."'s Pledges</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>Fund amount</th>
		<th>Fund state</th>
		<th>Charge Time</th>
		</tr>";

if($mypledges_result){
	while($row = mysqli_fetch_array($mypledges_result))
	{
			echo "<tr>";
    		#echo "<td>" . $row['fid'] . "</td>";
    		#echo "<td>" . $row['uid'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['ppid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['ouid']).'">'.htmlspecialchars($row['username']).'</a></td>';
    		#echo "<td>" . $row['pid'] . "</td>";
    		echo "<td>" . htmlspecialchars($row['famount']) . "</td>";
    		echo "<td>" . htmlspecialchars($row['fstate']) . "</td>";
    		echo "<td>" . htmlspecialchars($row['chargeTime']) . "</td>";
    		echo "</tr>";

	}; 
}

$mypledges_query->close();

/**************************************************
6) My Pledge rate
**************************************************/
	// $mypledgesrate_query = "SELECT project.pid as ppid, project.uid as ouid, pname, star, review, ratetime, owner_review from project right join sponRate on project.pid = sponRate.pid where sponRate.uid ={$_GET["id"]}";



	// // $mypledgesrate_query = "SELECT *  from sponRate where uid ={$_SESSION["uid"]}";
	// $mypledgesrate_result = mysqli_query($db,$mypledgesrate_query);

	$mypledgesrate_query = $db->prepare("SELECT project.pid as ppid, project.uid as ouid, pname,username, star, review, ratetime, owner_review from project natural join user right join sponRate on project.pid = sponRate.pid where sponRate.uid =?");
    $mypledgesrate_query->bind_param("i",$id);
    $mypledgesrate_query->execute();
    $mypledgesrate_result = $mypledgesrate_query->get_result();

		echo "<table>
		<caption>".$username."'s Rate</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>Stars</th>
		<th>Review</th>
		<th>Rate Time</th>
		</tr>";

if($mypledgesrate_result){
	while($row = mysqli_fetch_array($mypledgesrate_result))
	{
			echo "<tr>";
    		#echo "<td>" . $row['pid'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['ppid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['ouid']).'">'.htmlspecialchars($row['username']).'</a></td>';
    		echo "<td>" . htmlspecialchars($row['star']) . "</td>";
    		echo "<td>" . htmlspecialchars($row['review']) . "</td>";
    		echo "<td>" . htmlspecialchars($row['ratetime']) . "</td>";
    		#echo "<td>" . htmlspecialchars($row['owner_review']) . "</td>";
    		echo "</tr>";

	};
} 

#$mypledgesrate_query->close();
/**************************************************
7) recommend
**************************************************/
// 	$rec_keyword_query = "SELECT keyword  from keywordHistory where uid ={$_GET["id"]}";
// 	$rec_keyword_result = mysqli_query($db,$rec_keyword_query);

// 	// $rowcount=mysqli_num_rows($rec_result);
// 	// echo "count:";
// 	// echo $rowcount;

// 	while($row = mysqli_fetch_array($rec_keyword_result)){
// 		#echo $row['keyword'];

// 		$likes .= $row['keyword']. "|";

// 	}
// 	#$new_like = rtrim($likes,"| ");
// 	#echo $likes;
// 	#echo $new_like;

// 	$rec_tag_query = "SELECT tag  from tagHistory where uid ={$_GET["id"]}";
// 	$rec_tag_result = mysqli_query($db,$rec_tag_query);



// 	while($row = mysqli_fetch_array($rec_tag_result)){
// 		#echo $row['keyword'];

// 		$likes .= $row['tag']. "|";

// 	}
// 	$new_like = rtrim($likes,"| ");
// 	echo $new_like;


// 	$rec_query = "SELECT * from project where (pname REGEXP '$new_like'  or category REGEXP '$new_like' or tags REGEXP '$new_like' or description REGEXP '$new_like' ) and pjstate='incomplete'";
// 	$rec_result = mysqli_query($db,$rec_query);

// 	// $rowcount=mysqli_num_rows($rec_result);
// 	// echo "count:";
// 	// echo $rowcount;

// 		echo "<table border ='1'>
// 		<th>Recommend List</th>
// 		<tr>
// 		<th>Project ID</th>
// 		<th>Project Name</th>
// 		<th>Min amount</th>
// 		<th>Max amount</th>
// 		<th>Owner ID</th>
// 		<th>fund Deadline</th>
// 		<th>Project DeadLine</th>
// 		<th>Category</th>
// 		<th>Tags</th>
// 		<th>Description</th>
// 		</tr>";


// if($rec_result){

// 	while($row = mysqli_fetch_array($rec_result))
// 	{
// 			echo "<tr>";
//     		echo "<td>" . $row['pid'] . "</td>";
//     		echo "<td>" . $row['pname'] . "</td>";
//     		echo "<td>" . $row['minamount'] . "</td>";
//     		echo "<td>" . $row['maxamount'] . "</td>";
//     		echo "<td>" . $row['uid'] . "</td>";
//     		echo "<td>" . $row['fundDdl'] . "</td>";
//     		echo "<td>" . $row['projDdl'] . "</td>";
//     		echo "<td>" . $row['category'] . "</td>";
//     		echo "<td>" . $row['tags'] . "</td>";
//     		echo "<td>" . $row['description'] . "</td>";
//     		echo "</tr>";

// 	}; 

// }

}




?>




</body>
</html>
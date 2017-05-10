<?php
session_start();
require 'db.php';

#echo "cookie: ::::::";

#echo $_COOKIE["cookie_uid"];
?>

<!DOCTYPE html>


<html>
<head>
	<title>MainPage</title>
<!-- <script type="text/javascript">
	function add(){
		header("Location: mainpage.php");
	}
</script> -->


	<script type="text/javascript">
		function logout(){

  			window.location.href = "logout.php";
		}
		function edit_prof(){

  			window.location.href = "myinfo.php";
		}
		function create_proj(){

  			window.location.href = "projPost.php";
		}
		function friend(){

  			window.location.href = "friends.php";
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
		max-width: 250px;

	}
	#edit {
		/*float: left;*/
		margin-left: 15px;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	#create_proj {
		margin-left: 5px;
		margin-top: 10px;

	}
	#search_box {
		float: top;
		margin-left: 15px;
		width: 157px;
	}
	#searchs {
		margin-left: 5px;
	}
	#friend{
		margin-left: 5px;
	}
	#logout{
		margin-top: 10px;
		float: right;
		margin-right: 25px;
	}
	h2{
		margin-top: -30px;
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


// echo "<input type='submit' value='edit profile' onClick='edit_prof()';>";
// echo "<input type='submit' value='create project' onClick='create_proj()';>";
// echo "<input type='submit' value='logout' onClick='logout()';>";

// echo "<input id='edit' type='submit' value='Edit Profile' onClick='edit_prof()';>";
// echo "<input id = 'create_proj' type='submit' value='Create Project' onClick='create_proj()';>";
// echo "<input id = 'logout' type='submit' value='logout' onClick='logout()';>";

// echo "<form method='POST' action='brief_project_from_search.php'>";
// echo "<input id = 'search_box' type='text' name='searchtext' >";
// echo "<input id = 'searchs' type='submit' value='Search'>";
// echo "</form>";



echo "<br>";
echo "<br>";


if(isset($_SESSION["uid"])){
	// echo "Welcome: ID ";
	// echo $_SESSION["uid"];
	// echo "<br>";
	// echo "<br>";

	$uid = $_SESSION["uid"];

	// $query = "SELECT username FROM user where uid = '{$_SESSION["uid"]}'";
	// $res = $db->query($query);

	$query = $db->prepare("SELECT username FROM user where uid = ?");
	$query->bind_param("i", $uid);
	$query->execute();

	$query->bind_result($row);
	$query->fetch();
	#echo $row;

	if (!$row){
   	echo "Something wrong!!";
   	showerror();				# if query faild, show error message.
   	}

   	// while ($row){
    // $username = $row['username'];
    // }

    echo "<h2>Hi  ".$row."</h2>" ;

	echo "<input id='edit' type='submit' value='Edit Profile' onClick='edit_prof()';>";
	echo "<input id = 'create_proj' type='submit' value='Create Project' onClick='create_proj()';>";
	echo "<input id = 'friend' type='submit' value='friend' onClick='friend()';>";
	echo "<input id = 'logout' type='submit' value='logout' onClick='logout()';>";

	echo "<form method='POST' action='brief_project_from_search.php'>";
	echo "<input id = 'search_box' type='text' name='searchtext' >";
	echo "<input id = 'searchs' type='submit' value='Search'>";
	echo "</form>";

	$query->close();


/*************************************************
1) Recent Proeject List
**************************************************/

	// $recentproject_query = "SELECT *  from project where uid in (  select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	// // $recentproject_query = "SELECT *  from project where uid = {$_SESSION["uid"]}";
	// $recentproject_result = mysqli_query($db,$recentproject_query);


	// $recentproject_query = $db->prepare("SELECT *  from project where `uid` in (select user1 from friendship where user2 =?)");

	// $recentproject_query->bind_param("i", $uid);
	// $recentproject_query->execute();


	// if($recentproject_query){
	// 	echo "kong";
	// }
	// // $recentproject_query->bind_result($row);
	// // $recentproject_query->fetch();
	// $row = $recentproject_query->get_result();

	$recentproject_query = $db->prepare("SELECT *  from project natural join user where uid in (  select user1 from friendship where user2 = ? )");
    $recentproject_query->bind_param("i",$_SESSION["uid"]);
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

	while($row =mysqli_fetch_array($recentproject_result))
	{



			echo "<tr>";
    		#echo "<td>" . $row['pid'] . "</td>";
    		#echo "<td>" . $row['pname'] . "</td>";
    		echo '<td><a href="detailed_projects.php?prjID='.htmlspecialchars($row['pid']).'">'.htmlspecialchars($row['pname']).'</a></td>';
    		#echo "<td>" . $row['minamount'] . "</td>";
    		#echo "<td>" . $row['maxamount'] . "</td>";

    		#echo "<td>" . $row['uid'] . "</td>";
    		// echo '<td><a href="userpage.php?id='.htmlspecialchars($row['uid']).'">'.htmlspecialchars($row['uid']).'</a></td>';
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

$recentproject_query->close();


/**************************************************
2) Recent Comments
**************************************************/


	// $recentcomment_query = "SELECT *  from comment where uid in (  select user1 from friendship where user2 = {$_SESSION["uid"]} )";

	// $recentcomment_query = "SELECT project.pid as ppid, pname, project.uid as ouid, category, tags, posttime, comm, comment.uid as cuid from project right join comment on project.pid = comment.pid where comment.uid in ( select user1 from friendship where user2 = {$_SESSION["uid"]}  )";

	// $recentcomment_result = mysqli_query($db,$recentcomment_query);


	$recentcomment_query = $db->prepare("SELECT project.pid as ppid, pname, project.uid as ouid, category, tags, posttime, comm, comment.uid as cuid from project right join comment on project.pid = comment.pid where comment.uid in ( select user1 from friendship where user2 = ?  )");
    $recentcomment_query->bind_param("i",$_SESSION["uid"]);
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
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['ouid']).'">'.htmlspecialchars($row['ouid']).'</a></td>';
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
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['cuid']).'">'.htmlspecialchars($row['cuid']).'</a></td>';
    		echo "</tr>";

	}; 
}

$recentcomment_query->close();


/**************************************************
3) Recent Pledges
**************************************************/

	// $recentpledges_query = "SELECT project.pid as ppid, pname, fund.uid as fuid, famount, fstate from project right join fund on project.pid = fund.pid where fund.uid in ( select user1 from friendship where user2 = {$_SESSION["uid"]} )and fstate='incomplete'";

	// // $recentpledges_query = "SELECT *  from fund where uid in (  select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	// $recentpledges_result = mysqli_query($db,$recentpledges_query);

	$recentpledges_query = $db->prepare("SELECT project.pid as ppid, pname,username, fund.uid as fuid, famount, fstate from project natural join user right join fund on project.pid = fund.pid where fund.uid in ( select user1 from friendship where user2 = ? )and fstate='incomplete'");
    $recentpledges_query->bind_param("i",$_SESSION["uid"]);
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
    		#echo '<td><a href="userpage.php?id='.htmlspecialchars($row['fuid']).'">'.htmlspecialchars($row['fuid']).'</a></td>';

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


	// $recentLike_query = "SELECT project.pid  as ppid,pname,minamount,maxamount,project.uid as puid,fundDdl, projDdl, category, tags, description, likePj.uid as luid  from project right join likePj on project.pid = likePj.pid where likePj.uid in ( select user1 from friendship where user2 = {$_SESSION["uid"]} )";
	// $recentLike_result = mysqli_query($db,$recentLike_query);

	$recentLike_query = $db->prepare("SELECT project.pid  as ppid,pname,minamount,maxamount,project.uid as puid,fundDdl, projDdl, category, tags, description, likePj.uid as luid  from project right join likePj on project.pid = likePj.pid where likePj.uid in ( select user1 from friendship where user2 = ? )");
    $recentLike_query->bind_param("i",$_SESSION["uid"]);
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
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['puid']).'">'.htmlspecialchars($row['puid']).'</a></td>';
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
    		#echo "<td>" . $row['luid'] . "</td>";
    		echo '<td><a href="userpage.php?id='.htmlspecialchars($row['luid']).'">'.htmlspecialchars($row['luid']).'</a></td>';
    		echo "</tr>";

	};
}

$recentLike_query->close();
/**************************************************
4.5) My Project
**************************************************/

// $myproject_query = "SELECT *  from project where uid = {$_SESSION["uid"]} ";

// $myproject_result = mysqli_query($db,$myproject_query);


	$myproject_query = $db->prepare("SELECT *  from project natural join user where uid = ? ");
    $myproject_query->bind_param("i",$_SESSION["uid"]);
    $myproject_query->execute();
    $myproject_result = $myproject_query->get_result();

		echo "<table>
		<caption>My Projects List</caption>
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
    		#echo '<td><a href="userpage.php?id='.htmlspecialchars($row['uid']).'">'.htmlspecialchars($row['uid']).'</a></td>';
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

	$mypledges_query = $db->prepare("SELECT project.pid as ppid, pname,username, project.uid as ouid, famount, fstate, chargeTime from project natural join user right join fund on project.pid = fund.pid where fund.uid =?");
    $mypledges_query->bind_param("i",$_SESSION["uid"]);
    $mypledges_query->execute();
    $mypledges_result = $mypledges_query->get_result();


	// $mypledges_query = "SELECT project.pid as ppid, pname, project.uid as ouid, famount, fstate, chargeTime from project right join fund on project.pid = fund.pid where fund.uid ={$_SESSION["uid"]}";



	// $mypledges_query = "SELECT *  from fund where uid ={$_SESSION["uid"]}";
	#$mypledges_result = mysqli_query($db,$mypledges_query);

		echo "<table>
		<caption>My Pledges</caption>
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
    		#echo '<td><a href="userpage.php?id='.htmlspecialchars($row['ouid']).'">'.htmlspecialchars($row['ouid']).'</a></td>';
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

	$mypledgesrate_query = $db->prepare("SELECT project.pid as ppid, project.uid as ouid, pname, username, star, review, ratetime, owner_review from project natural join user right join sponRate on project.pid = sponRate.pid where sponRate.uid =?");
    $mypledgesrate_query->bind_param("i",$_SESSION["uid"]);
    $mypledgesrate_query->execute();
    $mypledgesrate_result = $mypledgesrate_query->get_result();

	// $mypledgesrate_query = "SELECT project.pid as ppid, project.uid as ouid, pname, star, review, ratetime, owner_review from project right join sponRate on project.pid = sponRate.pid where sponRate.uid ={$_SESSION["uid"]}";



	// $mypledgesrate_query = "SELECT *  from sponRate where uid ={$_SESSION["uid"]}";
	#$mypledgesrate_result = mysqli_query($db,$mypledgesrate_query);

		echo "<table>
		<caption>My Rate</caption>
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

$mypledgesrate_query->close();


/**************************************************
6.5) My like list
**************************************************/


	$mylikeprj_query = $db->prepare("SELECT *  from project natural join user where pid in ( select pid from likePj where uid = ?)");
    $mylikeprj_query->bind_param("i",$uid);
    $mylikeprj_query->execute();
    $mylikeprj_result = $mylikeprj_query->get_result();


		echo "<table>
		<caption>My Like Projects</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>fund Deadline</th>
		<th>Category</th>
		<th>Tags</th>
		</tr>";

if($mylikeprj_result){

	while($row =mysqli_fetch_array($mylikeprj_result))
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

$mylikeprj_query->close();





/**************************************************
7) recommend
**************************************************/

	$rec_keyword_query = $db->prepare("SELECT keyword  from keywordHistory where uid =?");
    $rec_keyword_query->bind_param("i",$_SESSION["uid"]);
    $rec_keyword_query->execute();
    $rec_keyword_result = $rec_keyword_query->get_result();


	// $rec_keyword_query = "SELECT keyword  from keywordHistory where uid ={$_SESSION["uid"]}";
	// $rec_keyword_result = mysqli_query($db,$rec_keyword_query);

	// $rowcount=mysqli_num_rows($rec_keyword_result);
	// echo "count:";
	// echo $rowcount;

	while($row = mysqli_fetch_array($rec_keyword_result)){
		#echo $row['keyword'];

		$likes .= htmlspecialchars($row['keyword']). "|";

	}

	$rec_keyword_query->close();
	// $new_like = rtrim($likes,"| ");
	 #echo $likes;
	// echo $new_like;

	$rec_tag_query = $db->prepare("SELECT tag  from tagHistory where uid =?");
    $rec_tag_query->bind_param("i",$_SESSION["uid"]);
    $rec_tag_query->execute();
    $rec_tag_result = $rec_tag_query->get_result();

	// $rec_tag_query = "SELECT tag  from tagHistory where uid ={$_SESSION["uid"]}";
	// $rec_tag_result = mysqli_query($db,$rec_tag_query);



	while($row = mysqli_fetch_array($rec_tag_result)){
		#echo $row['keyword'];

		$likes .= htmlspecialchars($row['tag']). "|";

	}
	$new_like = rtrim($likes,"| ");
	#echo $new_like;

	$rec_tag_query->close();

	$rec_query = $db->prepare("SELECT * from project natural join user where (pname REGEXP '$new_like'  or category REGEXP '$new_like' or tags REGEXP '$new_like' or description REGEXP '$new_like' )  and uid <> ? and pjstate='incomplete'");
	$rec_query->bind_param("i",$_SESSION["uid"]);
	$rec_query->execute();
	$rec_result = $rec_query->get_result();
	#$rec_result = mysqli_query($db,$rec_query);

	// $rowcount=mysqli_num_rows($rec_result);
	// echo "count:";
	// echo $rowcount;

		echo "<table>
		<caption>Recommend List</caption>
		<tr>
		<th>Project Name</th>
		<th>Owner</th>
		<th>fund Deadline</th>
		<th>Category</th>
		<th>Tags</th>
		</tr>";

if($rec_result){
	while($row = mysqli_fetch_array($rec_result))
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

}









?>






</body>
</html>

















<?php
session_start();

date_default_timezone_set("America/New_York");
$current_time = date("Y/m/d H:i:s");


if (isset($_SESSION['uid'])){
	$uid = $_SESSION['uid'];
	#$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
	require 'db.php';

	#$query = "SELECT username FROM user where uid = '$uid'";
	#$res = $db->query($query);

	$query = $db->prepare("SELECT username FROM user where uid = ?");
    $query->bind_param("i", $uid);
    $query->execute();
    $res = $query->get_result();

	if (!$res){
   	echo "Something wrong!!";
   	showerror();				# if query faild, show error message.
   	}

   	while ($row = $res->fetch_assoc()){
    $username = $row['username'];
    }

	require 'style.php';
	?>

	<html>
	<body>
<script type="text/javascript">
    function back_to_me(){
        window.location.href = "mainpage.php";
    }
</script>		
		<h2>Hi <?php echo $username ?>
		<input id = 'back' type='submit' value='back to my page' onClick='back_to_me()';>

	<table cellspacing="20" align=center>
		<tr>
			<td><strong>project name</strong></td>
			<td><strong>category</strong></td>
			<td><strong>tags</strong></td>
			<td><strong>owner</strong></td>
			<td><strong>minimum amount</strong></td>
			<td><strong>maximum amount</strong></td>
			<td><strong>current pledge</strong></td>
			<td><strong>description</strong></td>
			<td><strong>pledge ddl</strong></td>
			<td><strong>project ddl</strong></td>
			<td><strong>status</strong></td>
			<td><strong>like</strong></td>

		</tr>


	<?php
	$_SESSION['pid'] = $_GET['prjID'];

	#$find = "SELECT * FROM project where pid = ";
	#$find .= "'".$_SESSION['pid']."'";
	#$projinfo = $db->query($find);

	$find = $db->prepare("SELECT * FROM project natural join user where pid = ?");
    $find->bind_param("i", $_SESSION['pid']);
    $find->execute();
    $projinfo = $find->get_result();	


	$like = $db->prepare("SELECT count(uid) as COUN FROM likePj where pid = ?");
    $like->bind_param("i", $_SESSION['pid']);
    $like->execute();
    $likenum = $like->get_result();


	#$like = "SELECT count(uid) as COUN FROM likePj where pid = ";
	#$like .= "'".$_SESSION['pid']."'";
	#$likenum = $db->query($like);

	while ($row = $projinfo->fetch_assoc()){
		$pjstate = $row['Pjstate'];
	?>
	<tr>
		<td name = "pname"> <?php echo htmlspecialchars("{$row['pname']}") ?> </td>
		<td name = "category"> <?php echo htmlspecialchars("{$row['category']}"); $category = $row['category'] ;?> </td>
		<td name = "tags"> <?php echo htmlspecialchars("{$row['tags']}") ?> </td>
		<td name = "owner"> <?php echo htmlspecialchars("{$row['username']}"); $puid = $row['uid'];?> </td>
		<td name = "minamount"> <?php echo htmlspecialchars("{$row['minamount']}") ?> </td>
		<td name = "maxamount"> <?php echo htmlspecialchars("{$row['maxamount']}") ?> </td>
		<td name = "curramount"> <?php echo htmlspecialchars("{$row['current_amount']}") ?> </td>
		<td name = "description"> <?php echo htmlspecialchars("{$row['description']}") ?> </td>
		<td name = "fundDdl"> <?php echo htmlspecialchars("{$row['fundDdl']}") ?> </td>
		<td name = "projDdl"> <?php echo htmlspecialchars("{$row['projDdl']}") ?> </td>
		<td name = "Pjstate"> <?php echo htmlspecialchars("{$row['Pjstate']}") ?> </td>

		<?php
		while ($row = $likenum->fetch_assoc()){
			$likecount = $row['COUN'];
		echo "<td name = 'likePj'>";
		echo $likecount;
		echo "</td>";
		}
		?>

	</tr>
	</table>

	<table cellspacing="20" align=center>
	<tr>
		<td><strong>material download</strong></td>
		<td><strong>text material</strong></td>
		<td><strong>material time</strong></td>
	</tr>
	<?php
	}



	#add category into history table
	$addHistory = $db->prepare("INSERT INTO tagHistory (`uid`, `tag`, `searchTagTime`) VALUES (?,?,?)");
    $addHistory->bind_param("iss", $uid, $category, $current_time);
    $addHistory->execute();

	#list all materials for this project
	$getmaterial = $db->prepare("SELECT * from material WHERE pid = ?");
    $getmaterial->bind_param("i", $_SESSION['pid']);
    $getmaterial->execute();
    $mate = $getmaterial->get_result();

	#$getmaterial = "SELECT * from material WHERE pid = ";
	#$getmaterial .= "'".$_SESSION['pid']."'";
	#$getmaterial .= "ORDER by materialtime desc";
	#$mate = $db->query($getmaterial);

	while ($row = $mate->fetch_assoc()){
		$type = explode(".", $row['mediaMate']); 
	?>

	<tr>

		<?php
			if (end($type) == 'jpg' or end($type) == 'gif' or end($type) == 'png'){
		?>
		<td><img src= "<?php echo htmlspecialchars("{$row['mediaMate']}") ?>" width="180" /></td>
		
		<?php
			}
			else if (end($type) == 'mp4'){
		?>
		<td>
			<video width="180" controls="controls">
				<source src="<?php echo htmlspecialchars("{$row['mediaMate']}") ?>" type="video/<?php echo end($type) ?>" />
			</vedio>
		</td>

		<?php
			}
			else if (end($type) == 'mp3'){
		?>
		<td>
			<embed height="50" width="180" src="<?php echo htmlspecialchars("{$row['mediaMate']}") ?>" />
		</td>

		<?php
			}
		?>


		<td name = "textMate"> <?php echo htmlspecialchars("{$row['textMate']}") ?> </td>
		<td name = "materialtime"> <?php echo htmlspecialchars("{$row['materialtime']}") ?> </td>
	</tr>


	<?php
		}
	?>

	</table>

<form method="POST" action="post_comment.php">
	<table cellspacing="20" align=center>
	<tr>
		<td align = center><strong>comment</strong></td>
		<td><strong>user</strong></td>
		<td><strong>posttime</strong></td>
	</tr>
	<?php
	
	$getcomment = $db->prepare("SELECT * from comment WHERE pid = ?");
    $getcomment->bind_param("i", $_SESSION['pid']);
    $getcomment->execute();
    $comment = $getcomment->get_result();

	#$getcomment = "SELECT * from comment WHERE pid = ";
	#$getcomment .= "'".$_SESSION['pid']."'";
	#$comment = $db->query($getcomment);

	while ($row = $comment->fetch_assoc()){
	?>

	<tr>
		<td name = "comment"> <?php echo htmlspecialchars("{$row['comm']}") ?> </td>
		<td name = "user"> <a href="userpage.php?id=<?php echo htmlspecialchars("{$row['uid']}") ?>"> <?php echo htmlspecialchars("{$row['uid']}") ?> </td>
		<td name = "posttime"> <?php echo htmlspecialchars("{$row['posttime']}") ?> </td>
	</tr>

	<?php
		}
	?>
	<tr>
		<td><input type="text" size="30" name="new_comment" required></td>
		<td> </td>
		<td><input type="submit" value="post" name = "postcomment"></td>
	</tr>
	</table>
</form>

	<?php
	if($pjstate == 'complete'){
	?>
	<table cellspacing="20" align=center>
	<tr>
		<td><strong>user</strong></td>
		<td><strong>star</strong></td>
		<td><strong>review</strong></td>
		<td><strong>ratetime</strong></td>
	</tr>

	<?php
	
	$getreview = $db->prepare("SELECT * from sponRate WHERE pid = ? ORDER by ratetime desc");
    $getreview->bind_param("i", $_SESSION['pid']);
    $getreview->execute();
    $rate = $getreview->get_result();

	#$getreview = "SELECT * from sponRate WHERE pid = ";
	#$getreview .= "'".$_SESSION['pid']."'";
	#$getreview .= "ORDER by ratetime desc";
	#$rate = $db->query($getreview);

	while ($row = $rate->fetch_assoc()){
	?>

	<tr>
		<td name = "user"> <?php echo htmlspecialchars("{$row['uid']}") ?> </td>
		<td name = "star"> <?php echo htmlspecialchars("{$row['star']}") ?> </td>
		<td name = "review"> <?php echo htmlspecialchars("{$row['review']}") ?> </td>
		<td name = "ratetime"> <?php echo htmlspecialchars("{$row['ratetime']}") ?> </td>
	</tr>


	<?php
			}
		}
	?>

	</table>
	<?php
		if($pjstate == 'incomplete'){
	?>
	<form method="POST" action="pledge_action.php">
		<table align = "center">
			<tr>
				<td><strong>Pledge for this project:</strong></td>
				<td><input type="number" size="20" name="pledge" required></td>
				<td><p align=center><input type="submit" value="pledge!"></td>
			</tr>
		</table>
	</form>

	<?php
		}

    $getlike = $db->prepare("SELECT pid from likePj where uid = ? and pid = ?");
    $getlike->bind_param("ii", $_SESSION['uid'], $_SESSION['pid']);
    $getlike->execute();
    $get_like = $getlike->get_result();

	#$getlike = "SELECT pid from likePj where uid = ";
    #$getlike .= "'".$_SESSION['uid']."'";
    #$getlike .= " and pid = ";
    #$getlike .= "'".$_SESSION['pid']."'";
    #$get_like = $db->query($getlike);

    if(mysqli_num_rows($get_like)==0){

	?>


	<form method="POST" action="like_action.php">
		<table align = "center">
			<tr>
				<td><p align=center><input type="submit" value="I like this project!"></td>
			</tr>

		</table>
	</form>

	</body>
		</html>

	<?php
		}

	else{
		echo "<table align = 'center'><tr><td>You've liked this project!</td></tr></table>";
	}


	#$getspon = "SELECT uid from fund where uid = ";
    #$getspon .= "'".$_SESSION['uid']."'";
    #$getspon .= " and pid = ";
    #$getspon .= "'".$_SESSION['pid']."'";
    #$get_spon = $db->query($getspon);

    $getspon = $db->prepare("SELECT uid from fund where uid = ? and pid = ?");
    $getspon->bind_param("ii", $_SESSION['uid'], $_SESSION['pid']);
    $getspon->execute();
    $get_spon = $getspon->get_result();

    #$ifrate = "SELECT uid from sponRate where uid = ";
    #$ifrate .= "'".$_SESSION['uid']."'";
    #$ifrate .= " and pid = ";
    #$ifrate .= "'".$_SESSION['pid']."'";
    #$if_rate = $db->query($ifrate);

    $ifrate = $db->prepare("SELECT uid from sponRate where uid = ? and pid = ?");
    $ifrate->bind_param("ii", $_SESSION['uid'], $_SESSION['pid']);
    $ifrate->execute();
    $if_rate = $ifrate->get_result();

    if(mysqli_num_rows($get_spon)==1){
    	if(mysqli_num_rows($if_rate)==0){
    		if($pjstate == 'incomplete' or $pjstate == 'finished'){
    			echo "<table align = 'center'><tr><td>You cannot rate this project now(incomplete)!</td></tr></table>";
    		}
    		else if(($pjstate == 'complete')){
    		echo "<form action='rateproj.php'>
    		<table align = 'center'>
    		<td><p align=center><input type='submit' value='Go to rate this project!'></td></table></form>";
    			}
    		else{
    		echo "<table align = 'center'><tr><td>You cannot rate this project anymore(failed)!</td></tr></table>";
    		}
    		}
    	else{
    		echo "<table align = 'center'><tr><td>You've rated this project!</td></tr></table>";
    	}
		}

	# if the user is the owner of this project, show material add button
	if ($uid == $puid){
		?>
	<form method="POST" action="addMaterial.php">
		<table align = "center">
			<tr>
				<td><p align=center><input type="submit" value="Add material"></td>
			</tr>
		</table>
	</form>

		<?php
	}

	}



else{
		echo "Dude you are not authorized to access this page!";
	}


?>
<?php
session_start();

if (isset($_SESSION['uid'])){
	$uid = $_SESSION['uid'];

	require 'db.php';
	require 'style.php';
 
	$following = $db->prepare("SELECT uid, username from user, friendship where uid = user1 and user2 = ?");
    $following->bind_param("i",$uid);
    $following->execute();
    $followingResult = $following->get_result();


    $followed = $db->prepare("SELECT uid, username from user, friendship where uid = user2 and user1 = ?");
    $followed->bind_param("i",$uid);
    $followed->execute();
    $followedResult = $followed->get_result();
	

?>
<style type="text/css">
	#back {
		/*float: left;*/
		margin-left: 15px;
		margin-top: 10px;
		margin-bottom: 20px;
	}
</style>

	<script type="text/javascript">

		function back_to_me(){

  			window.location.href = "mainpage.php";
		}



	</script>

<table cellspacing="20" align = "center">
	<caption>users i followed</caption>
		<tr>
			<td><strong>user id</strong></td>
			<td><strong>name</strong></td>
		</tr>
<?php


echo "<input id = 'back' type='submit' value='back to my page' onClick='back_to_me()';>";


	while ($row = $followingResult->fetch_assoc()){
		?>
		<tr>
			<td name = "uid"><a href="userpage.php?id=<?php echo "{$row['uid']}" ?>"> <?php echo "{$row['uid']}" ?> </td>
			<td name = "username"> <?php echo "{$row['username']}" ?> </td>
		</tr>
		<?php
	}
?>
</table>



<table cellspacing="20" align = "center">
	<caption>users who followed me</caption>
		<tr>
			<td><strong>user id</strong></td>
			<td><strong>name</strong></td>
		</tr>
<?php
	while ($row = $followedResult->fetch_assoc()){
		?>
		<tr>
			<td name = "uid"><a href="userpage.php?id=<?php echo "{$row['uid']}" ?>"> <?php echo "{$row['uid']}" ?> </td>
			<td name = "username"> <?php echo "{$row['username']}" ?> </td>
		</tr>
		<?php
	}
?>

</table>

<?php


}


else{
		echo "Dude you are not authorized to access this page!";
	}


?>
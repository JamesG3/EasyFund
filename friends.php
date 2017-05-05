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
<table cellspacing="20" align = "center">
	<caption>users i followed</caption>
		<tr>
			<td><strong>user id</strong></td>
			<td><strong>name</strong></td>
		</tr>
<?php
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
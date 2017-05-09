<?php
session_start();

	date_default_timezone_set("America/New_York");
    $current_time = date("Y/m/d H:i:s");
if (isset($_SESSION['uid'])){
	$uid = $_SESSION['uid'];
	$pid = $_SESSION["pid"];//test
	$review = $_POST['review'];
	$star = $_POST["stars"];


	#$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
	require 'db.php';

	$ReviewPro = $db->prepare("INSERT INTO sponRate (`uid`, `pid`, `star`, `review`, `ratetime`) VALUES (?,?,?,?,?)");
    $ReviewPro->bind_param("iidss", $uid, $pid, $star, $review, $current_time);
    $ReviewPro->execute();
    echo "You have successfully rate this project!";

    ?>
    <td>
    	<a href="detailed_projects.php?prjID=<?php echo $_SESSION['pid']?>">Click here back to project page</a>
    </td>
    <?php


}


else{
		echo "Dude you are not authorized to access this page!";
	}


?>
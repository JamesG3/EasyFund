<?php
session_start();
date_default_timezone_set("America/New_York");
$current_time = date("Y/m/d H:i:s");
require 'db.php';

if (isset($_SESSION['uid'])){
	$comment = $_POST["new_comment"];
	
	$postcom = $db->prepare("INSERT INTO comment (`pid`, `uid`, `posttime`, `comm`) VALUES (?,?,?,?)");
    $postcom->bind_param("iiss", $_SESSION['pid'], $_SESSION['uid'], $current_time, $comment);
    $postcom->execute();
    echo "comment is posted successfully.\n";


    ?>
    <td>
    	<a href="detailed_projects.php?prjID=<?php echo $_SESSION['pid']?>">Click here back to project page</a>
    </td>
    <?php
}



else{
	echo "dude you cannot access this page without login!";
}







?>
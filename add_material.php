<?php
session_start();

date_default_timezone_set("America/New_York");
$current_time = date("Y/m/d H:i:s");

if (isset($_SESSION['uid'])){
	$uid = $_SESSION['uid'];
	$pid = $_SESSION["pid"];//test
	$textdata = $_POST['textdata'];

	#$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
	require 'db.php';

	$dir = "materials/";
	$file = $dir.basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;

	$path = "";

	#check if file exist

if (file_exists($file)) {
	if ($file != $dir){		#if there is a file to be uploaded
    	echo "Sorry, the file already exists, your file was not uploaded.";
	}
    $uploadOk = 0;
}

if ($uploadOk != 0) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)) {
    	$path = $file;
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.\n";
    } else {
        echo "Sorry, there was an error uploading your file.";
        $uploadOk = 0;
    }
}



if ($file == $dir){
	$uploadOk = 1;

	if ($textdata == ""){
		echo "You cannot upload nothing!";
		$uploadOk = 0;
	}
}
# insert into database
if ($uploadOk!=0){
	$upload = $db->prepare("INSERT INTO material (`pid`, `mediaMate`, `textMate`, `materialtime`) VALUES (?,?,?,?)");
    $upload->bind_param("isss", $pid, $path, $textdata, $current_time);
    $upload->execute();
    echo "Your material has been added to this project!";
}


}


else{
		echo "Dude you are not authorized to access this page!";
	}


?>
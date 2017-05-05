<?php
    date_default_timezone_set("America/New_York");
    $current_time = date("Y/m/d H:i:s");
    #echo $current_time;

    session_start();
if (isset($_SESSION['uid'])){


    $uid = $_SESSION["uid"];
    #$uname = 'Fanta';

    #$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
    require 'db.php';

    #get uid
    /*
    $getuid = "SELECT uid FROM user where username = ";
    $getuid .= "'".$uname."'";
    $getid = $db->query($getuid);
    while ($row = $getid->fetch_assoc()){
        $uid = $row['uid'];
      }
    */
    
    $input_pname = $_POST["pname"];
    $input_mini = $_POST["mini"];
    $input_maxi = $_POST["maxi"];
    $input_fddl = $_POST["fddl"];
    $input_pddl = $_POST["pddl"];
    $input_category = $_POST["category"];
    $input_tags = $_POST["tags"];
    $input_descri = $_POST["description"];



    $check1 = $db->prepare("SELECT pname FROM project where pname = ?");
    $check1->bind_param("s",$input_name);
    $check1->execute();
    $ifexist1 = $check1->get_result();

    #$check1 = "SELECT pname FROM project where pname = ";
    #$check1 .= "'".$input_pname."'";
   	#$ifexist1 = $db->query($check1);
    
   	if (!$ifexist1){
   		echo "Something wrong!!";
   		showerror();				# if query faild, show error message.
   	}

  if(mysqli_num_rows($ifexist1)==0){
      # insert this new user into user table
      $Pjstate = 'incomplete';
      $current_amount = 0;

      $postpj = $db->prepare("INSERT INTO project (`pname`, `minamount`, `maxamount`, `uid`, `fundDdl`, `projDdl`, `category`, `tags`, `description`, `Pjstate`, `pjposttime`, `current_amount`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
      $postpj->bind_param("siiisssssssi", $input_pname, $input_mini, $input_maxi, $uid, $input_fddl, $input_pddl, $input_category, $input_tags, $input_descri, $Pjstate, $current_time, $current_amount);
      $postpj->execute();
      echo "Your project is added!";

?>
      <form action="mainpage.php">
      <p align=center><input type="submit" value="back to my page">
      </form>
<?php

  }

  else{

    # the project name is already exist!
    echo "This project is already exist, please change another name.";

  }

}

else{
  echo "Dude you are not authorized to access this page!";
}


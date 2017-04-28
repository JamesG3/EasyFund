<?php
    
    #$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
    require 'db.php';

    $input_name = $_POST["uname"];
    $input_email = $_POST["email"];
    $input_hometown = $_POST["hometown"];
    $input_creditcard = $_POST["creditcard"];
    $input_password = $_POST["psw"];
    $input_interests = $_POST["interests"];


    $check1 = "SELECT username FROM user where username = ";
    $check1 .= "'".$input_name."'";

    $check2 = "SELECT email FROM user where email = ";
    $check2 .= "'".$input_email."'";


   	$ifexist1 = $db->query($check1);
    $ifexist2 = $db->query($check2);
   	if (!$ifexist1 or !$ifexist2){
   		echo "Something wrong!!";
   		showerror();				# if query faild, show error message.
   	}


  if(mysqli_num_rows($ifexist1)==0 and mysqli_num_rows($ifexist2)==0){
      # insert this new user into user table
      $register = $db->prepare("INSERT INTO user (`username`, `email`, `hometown`, `creditcard`, `password`, `interests`) VALUES (?,?,?,?,?,?)");
      $register->bind_param("ssssss", $input_name, $input_email, $input_hometown, $input_creditcard, $input_password, $input_interests);
      $register->execute();
      echo "Welcome to easyfund! Please login in.";

?>
      <form action="index.php">
      <p align=center><input type="submit" value="back to login page">
      </form>
<?php

  }

  else{

    # the user is already exist!
    echo "This user is already existed! ";
      // Relocate to the logout page
     #echo $_SESSION["message"];
     #session_destroy();
     #exit;
  }




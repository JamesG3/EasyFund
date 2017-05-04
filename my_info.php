<?php
    session_start();
    if (isset($_SESSION['uid'])){
    #$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
    require 'db.php';

    $input_name = $_POST["uname"];
    $input_email = $_POST["email"];
    $input_hometown = $_POST["hometown"];
    $input_creditcard = $_POST["creditcard"];
    $input_password = $_POST["psw"];
    $input_interests = $_POST["interests"];


    $check1 = "SELECT uid FROM user where username = ";
    $check1 .= "'".$input_name."'";

    $check2 = "SELECT uid FROM user where email = ";
    $check2 .= "'".$input_email."'";


    $ifexist1 = $db->query($check1);
    $ifexist2 = $db->query($check2);
    if (!$ifexist1 or !$ifexist2){
      echo "Something wrong!!";
      showerror();        # if query faild, show error message.
    }

  if(mysqli_num_rows($ifexist1)==0 and mysqli_num_rows($ifexist2)==0){
      #直接更新
    $update = $db->prepare("UPDATE user SET `username`= ?, `email`= ?, `hometown`= ?, `creditcard`= ?, `password`= ?, `interests`= ? WHERE `uid`= ?");
    $update->bind_param("ssssssi", $input_name, $input_email, $input_hometown, $input_creditcard, $input_password, $input_interests, $_SESSION['uid']);
    $update->execute();
    echo "You've changed your profile successfully.";
  }

  else if(mysqli_num_rows($ifexist1)==0 and mysqli_num_rows($ifexist2)!=0){

    while ($row = $ifexist2->fetch_assoc()){
    $uid = $row['uid'];
    }
    if($uid == $_SESSION['uid']){
      $update = $db->prepare("UPDATE user SET `username`= ?, `email`= ?, `hometown`= ?, `creditcard`= ?, `password`= ?, `interests`= ? WHERE `uid`= ?");
      $update->bind_param("ssssssi", $input_name, $input_email, $input_hometown, $input_creditcard, $input_password, $input_interests, $_SESSION['uid']);
      $update->execute();
      echo "You've changed your profile successfully.";
    }
    else{
      echo "This email already exist! please change another one!";
    }
  }


  else if(mysqli_num_rows($ifexist1)!=0 and mysqli_num_rows($ifexist2)==0){

    while ($row = $ifexist1->fetch_assoc()){
    $uid = $row['uid'];
    }
    if($uid == $_SESSION['uid']){
      $update = $db->prepare("UPDATE user SET `username`= ?, `email`= ?, `hometown`= ?, `creditcard`= ?, `password`= ?, `interests`= ? WHERE `uid`= ?");
      $update->bind_param("ssssssi", $input_name, $input_email, $input_hometown, $input_creditcard, $input_password, $input_interests, $_SESSION['uid']);
      $update->execute();
      echo "You've changed your profile successfully.";
    }
    else{
      echo "This username already exist! please change another one!";
    }  
  }

  else{
    while ($row = $ifexist1->fetch_assoc()){
    $uid = $row['uid'];
    }
    if($uid == $_SESSION['uid']){
      while ($row = $ifexist2->fetch_assoc()){
      $uid = $row['uid'];
      }
      if($uid == $_SESSION['uid']){
        $update = $db->prepare("UPDATE user SET `username`= ?, `email`= ?, `hometown`= ?, `creditcard`= ?, `password`= ?, `interests`= ? WHERE `uid`= ?");
        $update->bind_param("ssssssi", $input_name, $input_email, $input_hometown, $input_creditcard, $input_password, $input_interests, $_SESSION['uid']);
        $update->execute();
        echo "You've changed your profile successfully.";
      }
      else{
        echo "You cannot use this email.";
      }
    }
    else{
      echo "You cannot use this username.";
    }

  }

?>
      <form action="mainpage.php">
      <p align=center><input type="submit" value="back to main page">
      </form>
<?php
}

else{
  echo "Dude you are not authorized to access this page!";
}




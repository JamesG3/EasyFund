<?php
    session_start();
    if (isset($_SESSION['uid'])){
    #$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
    require 'db.php';

    $opsw = md5($_POST["opsw"]);
    $npsw1 = md5($_POST["npsw1"]);
    $npsw2 = md5($_POST["npsw2"]);


    $check1 = $db->prepare("SELECT password FROM user where uid = ?");
    $check1->bind_param("s", $_SESSION['uid']);
    $check1->execute();
    $ifsame = $check1->get_result();
    

    while ($row = $ifsame->fetch_assoc()){
    $o_psw = $row['password'];
    }

    if ($o_psw != $opsw){
      echo "Your password is not right!";
    }

    else{
      if ($npsw1 != $npsw2){
        echo "Your two new password is not same! Please enter them again.";
      }
      else{
      $update = $db->prepare("UPDATE user SET `password`= ? WHERE `uid`= ?");
      $update->bind_param("si", $npsw1, $_SESSION['uid']);
      $update->execute();
      echo "You've updated your password successfully.";
      }
    }


?>
      <form action="myinfo.php">
      <p align=center><input type="submit" value="back to myinfo page">
      </form>
<?php
}

else{
  echo "Dude you are not authorized to access this page!";
}




<?php
    session_start();

    date_default_timezone_set("America/New_York");
    $current_time = date("Y/m/d H:i:s");
    #$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
    require 'db.php';
    
    #echo $_POST['pledge'];
    #echo $_SESSION['uid'];
    #echo $_SESSION['pid'];


    $fstate = 'incomplete';


    $getCCN = "SELECT creditcard from user where uid = ";
    $getCCN .= "'".$_SESSION['uid']."'";
    $get_CCN = $db->query($getCCN);

    while ($row = $get_CCN->fetch_assoc()){
      $CCN = $row['creditcard'];
    }


    $check = "SELECT fid FROM fund where uid = ";
    $check .= "'".$_SESSION['uid']."'";
    $check .= " and pid = ";
    $check .= "'".$_SESSION['pid']."'";

   	$ifexist = $db->query($check);


   	if (!$ifexist){
   		echo "Something wrong!!";
   		showerror();				# if query faild, show error message.
   	}


  if(mysqli_num_rows($ifexist)==0){
      $addpledge = $db->prepare("INSERT INTO fund (`uid`, `pid`, `famount`, `fstate`, `chargeTime`, `CreditCardN`) VALUES (?,?,?,?,?,?)");
      $addpledge->bind_param("iiisss", $_SESSION['uid'], $_SESSION['pid'], $_POST['pledge'], $fstate, $current_time, $CCN);
      $addpledge->execute();
      echo "Thanks for your helping!";

  }

  else{
    while ($row = $ifexist->fetch_assoc()){
      $fid = $row['fid'];
    }

    $getfamount = "SELECT famount from fund where fid = ";
    $getfamount .= "'".$fid."'";
    $get_amount = $db->query($getfamount);
    while ($row = $get_amount->fetch_assoc()){
      $famount = $row['famount'];
    }

    $famount = $famount + $_POST['pledge'];

    $updatepledge = $db->prepare("UPDATE fund SET `famount`= ?, `chargeTime`= ?, `CreditCardN`= ? WHERE `fid`= ?");
    $updatepledge->bind_param("issi", $famount, $current_time, $CCN, $fid);
    $updatepledge->execute();
    echo 'Thanks for your funding us more!';



  }
  ?>
  <form action="mainpage.php">
    <p align=center><input type="submit" value="back to main page">
  </form>




<?php
    session_start();
    #$db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());
    require 'db.php';
    
    #echo $_POST['pledge'];
    #echo $_SESSION['uid'];
    #echo $_SESSION['pid'];

      $addlike = $db->prepare("INSERT INTO likePj (`pid`, `uid`) VALUES (?,?)");
      $addlike->bind_param("ii",$_SESSION['pid'], $_SESSION['uid']);
      $addlike->execute();
      echo "Thank you for liking this project!";

?>
      <form action="mainpage.php">
      <p align=center><input type="submit" value="back to main page">
      </form>
<?php





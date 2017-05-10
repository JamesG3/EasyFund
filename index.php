<?php 
session_start();
$cookie_name = "cookie_uid";
#echo "cookie: ::::::";

#echo $_COOKIE[$cookie_name];


if(isset($_COOKIE["cookie_uid"])) {

  $_SESSION["uid"] = $_COOKIE[$cookie_name];
  header("Location: mainpage.php");
}

?>


<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>EasyFund</title>
</head>
<body>
<h1 align=center>Welcome to EasyFund</h1>
<form method="POST" action="loginchk.php">

<table align=center>
  <tr>
    <td>Enter a username:</td>
    <td><input type="text" size="20" name="uname" required></td>
  </tr>
  <tr>
    <td>Enter a password:</td>
    <td><input type="password" size="20" name="psw" required></td>
  </tr>
</table>

<p align=center><input type="submit" value="login" name ="sub">


</form>
<form action="register.php">
<p align=center><input type="submit" value="register">
</form>

</body>
</html>



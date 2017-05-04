<?php
session_start();

if (isset($_SESSION['uid'])){
require 'style.php';
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Rate this project</title>
</head>
<body>
<h1 align=center>Rate this project</h1>
<form method="POST" action="rate_proj.php">
<table align=center>
  <tr>
    <td>Stars:</td>
    <td> <input type="text" size="10" name="stars"> </td>
  </tr>
  <tr>
    <td>Some brief review:</td>
    <td><textarea id = "input" rows=10 cols=40 name="review"></textarea></td>
  </tr>

</table>
<p align=center><input type="submit" value="submit this rate">


</form>
</body>
</html>

<?php
}

else{
  echo "dude you cannot access this page without login!";
}

<?php
session_start();

if (isset($_SESSION['uid'])){
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Add your material</title>
  <input id = 'back' type='submit' value='back to my page' onClick='back_to_me()';>
</head>
<script type="text/javascript">
    function back_to_me(){
        window.location.href = "mainpage.php";
    }
</script> 
<body>
<h1 align=center>AddMaterial</h1>
<form method="POST" action="add_material.php" enctype = "multipart/form-data">
<table align=center>
  <tr>
    <td>Upload Material:</td>
    <td><input type="file" name="fileToUpload" id = "fileToUpload"></td>
  </tr>
  <tr>
    <td>Or write something:</td>
    <td><textarea id = "input" rows=10 cols=40 name="textdata"></textarea></td>
  </tr>
</table>
<p align=center><input type="submit" value="Upload these material" name = "upload">

</form>
</body>
</html>

<?php
}

else{
  echo "dude you cannot access this page without login!";
}

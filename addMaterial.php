<?php
session_start()

#if (isset($_SESSION['uid'])){
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Add your material</title>
</head>
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
  <tr clospan = "2"><td><input type="submit" value="Upload material" name="upload"></td></tr>


</table>

</form>
</body>
</html>

<?php
#}

#else{
#  echo "dude you cannot access this page without login!";
#}

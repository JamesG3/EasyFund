<?php
session_start();
require 'style.php';

if (isset($_SESSION['uid'])){

?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Register</title>
</head>
<body>
<h1 align=center>Post your Project</h1>
<form method="POST" action="proj_Post.php">

<table align=center>
  <tr>
    <td>project name:</td>
    <td><input type="text" size="20" name="pname"></td>
  </tr>
  <tr>
    <td>minimum amount:</td>
    <td><input type="text" size="20" name="mini"></td>
  </tr>
  <tr>
    <td>maximum amount:</td>
    <td><input type="text" size="20" name="maxi"></td>
  </tr>
  <tr>
    <td>fund deadline:</td>
    <td><input type="text" size="20" name="fddl"></td>
  </tr>
  <tr>
    <td>project deadline:</td>
    <td><input type="text" size="20" name="pddl"></td>
  </tr>
  <tr>
    <td>category:</td>
    <td><input type="text" size="20" name="category"></td>
  </tr>
  <!--需要改为radio或者下拉菜单-->


  <tr>
    <td>tags:</td>
    <td><input type="text" size="20" name="tags"></td>
  </tr>
  <tr>
    <td>description:</td>
    <td><textarea id = "input" rows=5 cols=18 name="description"></textarea></td>
  </tr>
</table>

<p align=center><input type="submit" value="post it now">
<!--需要检查是否格式正确，所有信息必须都填写，不能为空-->

</form>
</body>
</html>

<?php
}

else{
  echo "Dude you are not authorized to access this page!";
}

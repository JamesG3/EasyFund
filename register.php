
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Register</title>
</head>
<body>
<h1 align=center>Register</h1>
<form method="POST" action="userRegister.php">

<table align=center>
  <tr>
    <td>username:</td>
    <td><input type="text" size="20" name="uname"></td>
  </tr>
  <tr>
    <td>email:</td>
    <td><input type="text" size="20" name="email"></td>
  </tr>
  <tr>
    <td>hometown:</td>
    <td><input type="text" size="20" name="hometown"></td>
  </tr>
  <tr>
    <td>creditcard:</td>
    <td><input type="text" size="20" name="creditcard"></td>
  </tr>
  <tr>
    <td>password:</td>
    <td><input type="text" size="20" name="psw"></td>
  </tr>
  <tr>
    <td>interests:</td>
    <td><input type="text" size="20" name="interests"></td>
  </tr>
</table>

<p align=center><input type="submit" value="register now">
<!--需要检查是否格式正确，所有信息必须都填写，不能为空-->

</form>
</body>
</html>

<?php

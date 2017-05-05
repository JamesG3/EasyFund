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
    <td><input type="text" size="20" name="uname" required></td>
  </tr>
  <tr>
    <td>email:</td>
    <td><input type="email" size="20" name="email" required></td>
  </tr>
  <tr>
    <td>hometown:</td>
    <td><input type="text" size="20" name="hometown" required></td>
  </tr>
  <tr>
    <td>creditcard:</td>
    <td><input type="text" size="20" name="creditcard" required pattern= "[0-9]{16}"></td>
  </tr>
  <tr>
    <td>password:</td>
    <td><input type="text" size="20" name="psw" required></td>
  </tr>
  <tr>
    <td>interests:</td>
    <td><input type="text" size="20" name="interests" required></td>
  </tr>
</table>

<p align=center><input type="submit" value="register now">

</form>
</body>
</html>

<?php

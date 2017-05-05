<?php
session_start();
require 'style.php';

if (isset($_SESSION['uid'])){

?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Register</title>
  <input id = 'back' type='submit' value='back to my page' onClick='back_to_me()';>
</head>
<body>
<h1 align=center>Post your Project</h1>


<script type="text/javascript">
    function back_to_me(){
        window.location.href = "mainpage.php";
    }
</script>


<form method="POST" action="proj_Post.php">

<table align=center>
  <tr>
    <td>project name:</td>
    <td><input type="text" size="20" name="pname" required></td>
  </tr>
  <tr>
    <td>minimum amount:</td>
    <td><input type="number" size="20" name="mini" required></td>
  </tr>
  <tr>
    <td>maximum amount:</td>
    <td><input type="number" size="20" name="maxi" required></td>
  </tr>
  <tr>
    <td>fund deadline:</td>
    <td><input type="date" size="20" name="fddl" required></td>
  </tr>
  <tr>
    <td>project deadline:</td>
    <td><input type="date" size="20" name="pddl" required></td>
  </tr>
  <tr>
    <td>category:</td>
    <td><select name = "category">
      <option value="CD">CD</option>
      <option value="Live">Live</option>
      <option value="Instrument">Instrument</option>
      <option value="Poem">Poem</option>
      <option value="Robotic">Robotic</option>
    </select>
    </td>
  </tr>

  <tr>
    <td>tags:</td>
    <td><input type="text" size="20" name="tags" required></td>
  </tr>
  <tr>
    <td>description:</td>
    <td><textarea id = "input" rows=5 cols=18 name="description" required></textarea></td>
  </tr>
</table>

<p align=center><input type="submit" value="post it now">

</form>
</body>
</html>

<?php
}

else{
  echo "Dude you are not authorized to access this page!";
}

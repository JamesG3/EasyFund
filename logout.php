<?php
session_start();

setcookie("cookie_uid", '', time() - 3600, "/");
session_destroy();

header("Location: index.php");



?>
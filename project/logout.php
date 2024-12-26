<?php
session_start();


$_SESSION = [];

session_unset();
session_destroy();
setcookie('useremail', $useremail, time() - (86400), "/");
setcookie('password', $password, time() - (86400), "/");
header("Location: index.php");
exit();
?>

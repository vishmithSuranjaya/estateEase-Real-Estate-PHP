<?php
$password = "Password1234";

$hash = password_hash($password,PASSWORD_BCRYPT);
echo $hash;
?>
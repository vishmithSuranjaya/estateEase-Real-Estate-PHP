<?php
require_once './classes/Registered_user.php';
require_once './classes/Admin.php';

/// login



if (isset($_COOKIE['useremail']) && isset($_COOKIE['password'])) {
    $useremail = $_COOKIE['useremail'];
    $password = $_COOKIE['password'];
}

$login = new Registered_user();
$login->setPassword($password);
$login->setUseremail($useremail);
$result = $login->Login();

if ($result == 1) {
    $_SESSION['login'] = true;
    $_SESSION["id"] = $login->idUser(); //getting user NIC from the resultset
    $_SESSION['username'] = $login->userName(); //getting username from resultset
    $_SESSION['useremail'] = $login->userEmail();
    $_SESSION['role'] = $login->getRole();

    if ($_SESSION['role'] == "customer") {
        $_SESSION['status'] = 1;
    } else {
        $login->logout();
        session_start();
        $admin = new Admin($useremail);
        $_SESSION['id'] = $admin->idUser();
        $_SESSION['useremail'] = $admin->userEmail();
        $_SESSION['username'] = $admin->userName();
        $_SESSION['role'] = $admin->getRole();
        $_SESSION['status'] = 1;
    }
}
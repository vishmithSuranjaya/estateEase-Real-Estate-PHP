<?php
require '../login.php';
session_start();

require_once '../classes/Admin.php';
if (isset($_SESSION['useremail'])) {
        $admin = new Admin($_SESSION['useremail']);
        $admin->logout();
        
        
}

?>
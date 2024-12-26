<?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nic'])){
    $nic = $_POST['nic'];
    
    require_once '../classes/Admin.php';

    if (isset($_SESSION['useremail'])) {
        $admin = new Admin($_SESSION['useremail']);
        $admin->remove_ban($nic);
        
        
}
}else{
    http_response_code(400); 
    echo "Invalid request.";
}


?>

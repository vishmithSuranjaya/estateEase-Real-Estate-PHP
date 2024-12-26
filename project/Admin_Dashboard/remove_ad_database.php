<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ads'])) {
    $Ad_ID = $_POST['ads'];
    


    require_once '../classes/Admin.php';

    if (isset($_SESSION['useremail'])) {
        $admin = new Admin($_SESSION['useremail']);
        $admin->remove_ad_database($Ad_ID);
        
        
}
} else {
    
    http_response_code(400); 
    echo "Invalid request.";
}
?>

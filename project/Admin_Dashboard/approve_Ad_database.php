<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ad'])) {
    $Ad_ID = $_POST['ad'];
    
    require_once '../classes/Admin.php';

    if (isset($_SESSION['useremail'])) {
        $admin = new Admin($_SESSION['useremail']);
        $admin->Advertisement_approve($Ad_ID);
        
        
}
} else {
    
    http_response_code(400); 
    echo "Invalid request.";
}
?>

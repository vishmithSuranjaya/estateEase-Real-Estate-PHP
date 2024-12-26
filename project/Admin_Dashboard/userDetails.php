<html>
<head>
    <link rel='stylesheet' href='admin_panel.css'>

    <title>User Details</title>
    <link rel="icon" href="../images/logo.png" type="image/png">
</head>
<body>
    
</body>
</html>

<?php
session_start();
if(isset($_GET['nic']) && isset($_GET['rowNumber'])){
    $nic = htmlspecialchars($_GET['nic']);
    $rowNumber = $_GET['rowNumber'];
} else {
    echo '<h3 style="color:red">No NIC Provided!</h3>';
    exit();
}
require_once '../classes/Admin.php';

if (isset($_SESSION['useremail'])) {
        $admin = new Admin($_SESSION['useremail']);
        $admin->viewUser($nic,$rowNumber);
        
        
}


?>
<?php
include './classes/dbConnector.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad_id = $_POST['ad_id'];
    $nic = $_POST['nic'];

    $dbcon = new dbConnector;
    $con = $dbcon->getConnection();
    
    // Check if the ad is already in the wishlist table with the user's id
    $queryCheck = "SELECT * FROM wishlist WHERE nic = ? AND ad_id = ?";
    $stmtCheck = $con->prepare($queryCheck);
    $stmtCheck->bindValue(1, $nic);
    $stmtCheck->bindValue(2, $ad_id);
    $stmtCheck->execute();

    if ($stmtCheck->rowCount() > 0) {
        // If the ad exists in the wishlist table, remove it from the wishlist table
        $queryDelete = "DELETE FROM wishlist WHERE nic = ? AND ad_id = ?";
        $stmtDelete = $con->prepare($queryDelete);
        $stmtDelete->bindValue(1, $nic);
        $stmtDelete->bindValue(2, $ad_id);
        $stmtDelete->execute();

        $response = ['success' => true, 'action' => 'removed'];
    } else {
        // If the ad does not exist in the wishlist, add it to the wishlist
        $queryInsert = "INSERT INTO wishlist (nic, ad_id) VALUES (?, ?)";
        $stmtInsert = $con->prepare($queryInsert);
        $stmtInsert->bindValue(1, $nic);
        $stmtInsert->bindValue(2, $ad_id);
        $stmtInsert->execute();

        $response = ['success' => true, 'action' => 'added'];
    }

    echo json_encode($response);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>

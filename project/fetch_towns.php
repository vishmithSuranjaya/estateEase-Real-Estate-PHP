<?php

include './classes/dbConnector.php';

header('Content-Type: application/json');

if (isset($_GET['district'])) {
    $district = $_GET['district'];

    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();

    $sql = 'SELECT town FROM town WHERE district = ?';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(1, $district);
    $stmt->execute();

    $towns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($towns);
}
?>
<?php
include_once './classes/dbConnector.php';
// Database connection



// Fetch towns based on selected district
if (isset($_POST['district'])) {
    $district = $_POST['district'];
    $dbcon = new dbConnector;
    $con = $dbcon->getConnection();
    
    $query = "SELECT town_id, town FROM town WHERE district = ?";
    try{
        $stmt = $con->prepare($query);
        $stmt->bindValue(1, $district);
        $stmt->execute();
   
    

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['town'] . "'>" . $row['town'] . "</option>";
        }
    } else {
        echo "<option value=''>No towns found</option>";
    }
    }catch(PDOException $e){
        die("Connection failed".$e->getMessage());
    }
    
    $stmt->close();
}

$connection->close();
?>

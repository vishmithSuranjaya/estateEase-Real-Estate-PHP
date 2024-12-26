<?php
include_once 'DbConnector.php';

$dbcon = new DbConnector();
$con = $dbcon->getConnection();

while (true) {
    try {
        
        $sql = 'SELECT ad_id FROM bids WHERE end_time <= NOW()';
        $query = $con->query($sql);
        $bidsToUpdate = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($bidsToUpdate as $bid) {
            
            $ad_id = $bid['ad_id'];
            
            $sql11 = 'SELECT number_of_bids FROM bids WHERE ad_id = :ad_id';
            $query11 = $con->prepare($sql11);
            $query11->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
            $query11->execute();

            $rs =$query11->fetch(PDO::FETCH_ASSOC);

            if($rs && ($rs['number_of_bids'] !== NULL || $rs['number_of_bids'] !== 0)){

                try {
                    
                    $sql13 = 'DELETE FROM advertisement WHERE ad_id = :ad_id';
                    $query13 = $con->prepare($sql13);
                    $query13->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
                    $query13->execute();

                    if ($query13->rowCount() > 0) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['error' => 'Advertisement not found']);
                    }
                }
                
                catch (Exception $ex) {
                    http_response_code(500);
                    echo json_encode(['error' => $ex->getMessage()]);
                }

            }

            else{

                try {
                    
                    
                    $sql14 = 'DELETE FROM bids WHERE ad_id = :ad_id';
                    $query14 = $con->prepare($sql14);
                    $query14->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
                    $query14->execute();
                    
                    
                    $sql6 = "UPDATE advertisement SET category = 'Fixed' WHERE ad_id = ?";
                    $query6 = $con->prepare($sql6);
                    $query6->bindParam(1, $ad_id, PDO::PARAM_INT);
                    $query6->execute();


                    if ($query14->rowCount() > 0 && $query6->rowCount() > 0) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['error' => 'Bid not found']);
                    }
                     
                    
                }
                     
                     
                catch (Exception $ex) {
                    http_response_code(500);
                    echo json_encode(['error' => $ex->getMessage()]);
                }

            }
        }

        sleep(15);
    } catch (Exception $ex) {
        error_log('Error monitoring bids: ' . $ex->getMessage());
        sleep(15); 
    }
}
?>

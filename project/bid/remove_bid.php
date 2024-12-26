<?php
session_start();
ob_start();

header('Content-Type: application/json');
////include_once 'DbConnector.php';
require_once '../classes/BidAds.php';
require_once '../classes/Email.php';



$dbcon = new DbConnector();
$con = $dbcon->getConnection();

$ad_id = $_GET['ad_id'];

$sql11 = 'SELECT number_of_bids FROM bids WHERE ad_id = :ad_id';


try {
    $query11 = $con->prepare($sql11);
    $query11->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
    $query11->execute();
    
    $rs =$query11->fetch(PDO::FETCH_ASSOC);
    
    if($rs && ($rs['number_of_bids'] !== NULL || $rs['number_of_bids'] !== 0)){
    
        try {
            
            $bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);
            $result = $bid->emailWinner($ad_id);
            
            
            //$bid->setPriceAfterBid($ad_id);
            
            $mail = new Mail();
            $receiver = $result['current_bidder_email'];
            $subject = "EstateEase - Winner Of the Bid";
            $body = "<p>You have won the bid for the Auction Property!</br></p>"
                    . "<p>Please click the below link to pay the advance money to reserve your property!</br></p>"
                    . "<p>http://localhost/Project_Final/bidPayment.php?s=".$ad_id."</p>";
            $mail->sendMail($receiver, $subject, $body);
            
            
            $sql = "UPDATE advertisement SET category = 'hidden' WHERE ad_id = ?";
            $query1 = $con->prepare($sql);
            $query1->bindParam(1, $ad_id, PDO::PARAM_INT);
            $query1->execute();
            
//            $sql2 = 'DELETE FROM bids WHERE ad_id = :ad_id';
//            $query2 = $con->prepare($sql2);
//            $query2->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
//            $query2->execute();
            
            if ($query1->rowCount() > 0) {
                ob_clean();
                echo json_encode(['success' => true]);
                ob_flush();
            } else {
                ob_clean();
                echo json_encode(['error' => 'Advertisement not found']);
                ob_flush();
            }
        }
        catch (Exception $ex) {
            http_response_code(500);
            echo json_encode(['error' => $ex->getMessage()]);
        }
        
    }
    
    else{
        
        try {
//            $sql = 'DELETE FROM bids WHERE ad_id = :ad_id';
//            $query = $con->prepare($sql);
//            $query->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
//            $query->execute();
            
            $sql6 = "UPDATE advertisement SET category = 'Fixed' WHERE ad_id = ?";
            $query6 = $con->prepare($sql6);
            $query6->bindParam(1, $ad_id, PDO::PARAM_INT);
            $query6->execute();
            

            if ($query->rowCount() > 0 && $query6->rowCount() > 0) {
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

} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode(['error' => $ex->getMessage()]);
}



?>

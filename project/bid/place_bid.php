<?php
session_start();
include 'DbConnector.php';
include '../classes/Email.php';
header('Content-type: application/json');

$dbcon = new DbConnector();
$con = $dbcon->getConnection();

$ad_id = $_POST['ad_id'];
$bid_amount = $_POST['bid_amount'];
$nic = $_POST['nic'];
$email = $_POST['email'];

try {
    $sql = 'SELECT current_bid,min_auc_price FROM bids WHERE ad_id=:ad_id';
    $query = $con->prepare($sql);
    $query->bindParam(':ad_id',$ad_id,PDO::PARAM_INT);
    $query->execute();
    
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    if($result){
        $current_bid = $result['current_bid'];
        $min_auc_price = $result['min_auc_price'];
        
        
        
        if($bid_amount > $min_auc_price){
        
            if($bid_amount > $current_bid){
                $new_sql = 'UPDATE bids SET current_bid=:bid_amount, number_of_bids=number_of_bids+1 WHERE ad_id=:ad_id';
                $new_query = $con->prepare($new_sql);
                $new_query->bindParam(':bid_amount',$bid_amount,PDO::PARAM_STR);
                $new_query->bindParam(':ad_id',$ad_id,PDO::PARAM_INT);
                $new_query->execute();
               
                
                $checking_sql = 'SELECT * FROM bidder WHERE ad_id =:ad_id';
                $checking_query = $con->prepare($checking_sql);
                $checking_query->bindParam(':ad_id',$ad_id,PDO::PARAM_INT);
                $checking_query->execute();
                
                $sendEmails = false;
                $previous_email = null;
                
                if($checking_query->rowCount() > 0){
                    
                    $bidder_record = $checking_query->fetch(PDO::FETCH_ASSOC);
                    $previous_nic = $bidder_record['nic'];
                    $previous_email = $bidder_record['current_bidder_email'];
                    
                    $updateSql = 'UPDATE bidder SET previous_bidder=:previous_nic, previous_bidder_email=:previous_email, nic=:nic, current_bidder_email=:email WHERE ad_id=:ad_id';
                    $update_query = $con->prepare($updateSql);
                    $update_query->bindParam(':previous_nic',$previous_nic,PDO::PARAM_STR);
                    $update_query->bindParam(':previous_email',$previous_email,PDO::PARAM_STR);
                    $update_query->bindParam(':nic',$nic,PDO::PARAM_STR);
                    $update_query->bindParam(':email',$email,PDO::PARAM_STR);
                    $update_query->bindParam(':ad_id',$ad_id,PDO::PARAM_INT);
                    $update_query->execute();
                    
                    
                    
                    $sendEmails = true;
                    
                }else{
                    $sqlNew = 'INSERT INTO bidder (ad_id,nic,current_bidder_email) VALUES(:ad_id,:nic,:email)';
                    $queryNew = $con->prepare($sqlNew);
                    $queryNew->bindParam(':ad_id',$ad_id,PDO::PARAM_INT);
                    $queryNew->bindParam(':nic',$nic,PDO::PARAM_STR);
                    $queryNew->bindParam(':email',$email,PDO::PARAM_STR);
                    $queryNew->execute();
                      
                    $sendEmails = true;
                    
                }
                echo json_encode(['success' => true, 'sendEmails' => $sendEmails, 'previous_email' => $previous_email]);
                
                
            }else{
                echo json_encode(['error' => 'Your bid must be higher than the current bid']);
            }
            
        }else{
            echo json_encode(['error' => 'The initial bid must be higher than the minimum auction price!']);
        }
        
    }else{
        echo json_encode(['error' => 'Ad not Found!']);
    }
    
} catch (Exception $ex) {
    http_response_code(500);
    echo json_encode(['error' => $ex->getMessage()]);
}

?>
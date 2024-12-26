<?php
//include './classes/dbConnector.php';
include 'Advertisement.php';
session_start();

class BidAdds extends Advertisement{
    private $ad_id;
    private $minPrice;
    private $timePeriod;
    private $price;
    private $contactNo;
    private $description;
    private $title;
    private $district;
    private $landArea;
    private $town;
    private $town_id;
    private $category;
    private $type;
    private $longitude;
    private $latitude;
    private $no_of_bedrooms;
    private $no_of_bathrooms;
    private $no_of_floors;
    private $floorArea;
    private $image01;
    private $image02;
    private $image03;
    private $image04;
    private $image05;
    private $verification_doc;
    //constructor
    public function __construct($category,$type,$no_of_bedrooms,$no_of_bathrooms,$no_of_floors,$floorArea,$landArea,$title,$description,$price,$district,$town,$contactNo,$minPrice,$timePeriod,$logitude,$lattitude,$verification_doc,$image1,$image2,$image3,$image4,$image5){
      
        $this->category = $category;
        $this->type = $type;
        $this->no_of_bedrooms = $no_of_bedrooms;
        $this->no_of_bathrooms = $no_of_bathrooms;
        $this->no_of_floors = $no_of_floors;
        $this->floorArea = $floorArea;
        $this->landArea = $landArea;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->district = $district;
        $this->town = $town;
        $this->contactNo = $contactNo;
        $this->minPrice = $minPrice;
        $this->timePeriod = $timePeriod;
        $this->longitude = $logitude;
        $this->latitude = $lattitude;
        $this->image01 = $image1;
        $this->image02 = $image2;
        $this->image03 = $image3;
        $this->image04 = $image4;
        $this->image05 = $image5;
        $this->verification_doc = $verification_doc;
        
    }
     
    
    
//function for posting a bid ad to the system
    public function postBidAdd(){           //sending for admin approval
        $nic = $_SESSION['id'];
       

        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();

        $query1 = "SELECT * FROM town WHERE town = ?";  //getting town_id from the town table by entering town
        try{
            $pstmt = $con->prepare($query1);
            $pstmt->bindValue(1,$this->town);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);

            $this->town_id = $row['town_id'];
        }catch(PDOException $e){
            die("Connection failed".$e->getMessage());
        }


        $query2 = "INSERT INTO pending_ad_approval(nic,town_id,land_Area,longitude,latitude,contact_No,price,type,description,title,category,no_of_bedrooms,no_of_bathrooms,no_of_floors,floor_area,end_time,min_auc_price,verify_doc,image1,image2,image3,image4,image5) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";   //verification img and the images are not added

        try{
            $pstmt = $con->prepare($query2);
            $pstmt->bindValue(1,$nic);
            $pstmt->bindValue(2,$this->town_id);
            $pstmt->bindValue(3,$this->landArea);
            $pstmt->bindValue(4,$this->longitude);
            $pstmt->bindValue(5,$this->latitude);
            $pstmt->bindValue(6,$this->contactNo);
            $pstmt->bindValue(7,$this->price);
            $pstmt->bindValue(8,$this->type);
            $pstmt->bindValue(9,$this->description);
            $pstmt->bindValue(10,$this->title);
            $pstmt->bindValue(11,$this->category);
            $pstmt->bindValue(12,$this->no_of_bedrooms);
            $pstmt->bindValue(13,$this->no_of_bathrooms);
            $pstmt->bindValue(14,$this->no_of_floors);
            $pstmt->bindValue(15,$this->floorArea);
            $pstmt->bindValue(16,$this->timePeriod);
            $pstmt->bindValue(17,$this->minPrice);            //verification doc not binned
            $pstmt->bindParam(18,$this->verification_doc,PDO::PARAM_LOB);
            $pstmt->bindParam(19,$this->image01,PDO::PARAM_LOB);            
            $pstmt->bindParam(20,$this->image02,PDO::PARAM_LOB);            
            $pstmt->bindParam(21,$this->image03,PDO::PARAM_LOB);            
            $pstmt->bindParam(22,$this->image04,PDO::PARAM_LOB);            
            $pstmt->bindParam(23,$this->image05,PDO::PARAM_LOB);            
                        
            $pstmt->execute();

            // Check if insertion was successful
            if ($pstmt->rowCount() > 0) {
                
                return 1;
            } else {
                
                return 0;
            }

        }catch(PDOException $e){
            die("Connection Failed!".$e->getMessage());
        }
    }
    //funciton for getting the bid information in the specific bid ad
    public function count_and_update_bids($ad_id){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT current_bid, number_of_bids, min_auc_price FROM bids WHERE ad_id = :ad_id';
        $query = $con->prepare($sql);
        $query->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result['current_bid'] === null || $result['number_of_bids'] === null) {
            $sql_update = 'UPDATE bids SET current_bid = 0, number_of_bids = 0 WHERE ad_id = :ad_id';
            $query_update = $con->prepare($sql_update);
            $query_update->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
            $query_update->execute();

            // Fetch the updated result
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }  

        return $result;
    }
    //function for emailing the winner of the bid after the timer runs out
    public function emailWinner($ad_id){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();
        try {
            $sql2 = "SELECT nic,current_bidder_email FROM bidder WHERE ad_id = :ad_id";
            $query = $con->prepare($sql2);
            $query->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
           
            return $result;
        } catch (Exception $ex) {
            die("ERROR".$e->getMessage());
        }
        
    }
    //function for setting the price in the advertisement table by moving current bid to the price column in the advertisement table.
    public function setPriceAfterBid($ad_id) {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        try {
            $sql2 = "SELECT current_bid FROM bids WHERE ad_id = :ad_id";
            $query = $con->prepare($sql2);
            $query->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $price = $result['current_bid'];

                $sql3 = "UPDATE advertisement SET price = :price WHERE ad_id = :ad_id";
                $query = $con->prepare($sql3);
                $query->bindParam(':price', $price, PDO::PARAM_INT);
                $query->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
                $query->execute();
            } else {
                throw new Exception("No bid found for ad_id: " . $ad_id);
            }

        } catch (Exception $ex) {
            error_log("Error in setPriceAfterBid: " . $ex->getMessage());
            echo "An error occurred while updating the price.";
        } finally {
            $con = null;
        }
    }

    //function for checking the payment table if the respective payment has alreay been made
    public function checkPaymentsTable($ad_id){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        try {
            $sqll = "SELECT * FROM payment WHERE ad_id = ?";
            $query = $con->prepare($sqll);
            $query->bindParam(1, $ad_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if(count($result) > 0){
                return true;
            } else {
                return false;
            }

        } catch (Exception $ex) {
            die("ERROR: " . $ex->getMessage());
        }
    }
    //function for getting the information of the ended bid ads from the system
    public function checkAdTable($ad_id){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        try {
            $sqll = "SELECT * FROM advertisement WHERE ad_id = ? AND category = 'hidden'";
            $query = $con->prepare($sqll);
            $query->bindParam(1, $ad_id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if(count($result) > 0){
                return true;
            } else {
                return false;
            }

        } catch (Exception $ex) {
            die("ERROR: " . $ex->getMessage());
            return false;
        }
        finally {
            $con = null;
        }
    }

    //function for getting the time in the timer in the bid ad.
    public function update_time($ad_id){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
            
            $sql = 'SELECT TIMESTAMPDIFF(SECOND, NOW(), end_time) AS remaining_seconds FROM bids WHERE ad_id = :ad_id';
            $query = $con->prepare($sql);
            $query->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $remaining_seconds = max(0, $result['remaining_seconds']);
                echo json_encode(['remaining_time' => ['total_seconds' => $remaining_seconds]]);
            } else {
                echo json_encode(['error' => 'Bid not found']);
            }
        } catch (Exception $ex) {
            http_response_code(500); 
            echo json_encode(['error' => $ex->getMessage()]);
        }
    }
    //function for getting the nic of the user who posted the advertisement
    public function getAdOwnerNICbyAdId($ad_id) {
    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();
    
    try {
        $sql = "SELECT nic FROM advertisement WHERE ad_id = :ad_id";
        $query = $con->prepare($sql);
        $query->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nic'] : null;
    } catch (Exception $ex) {
        die("ERROR: " . $ex->getMessage());
    } finally {
        $con = null;
    }
}
    //function for getting the details of an ad from the ad id 
    public function getAdDetails($Ad_ID){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();
        
        $sql = 'SELECT 
                a.*, 
                t.town AS town, 
                t.district AS district, 
                u.name AS name, 
                u.email AS email, 
                u.contact_No AS originalContact,
                b.end_time AS end_time, 
                b.min_auc_price AS min_auc_price,
                b.current_bid AS current_bid,
                b.number_of_bids AS number_of_bids,
                bi.nic AS current_bidder_nic,
                bi.current_bidder_email AS current_bidder_email,
                i.image1 as image1, 
                i.image2 as image2, 
                i.image3 as image3, 
                i.image4 as image4, 
                i.image5 as image5,
                b.verify_doc as verify_doc
            FROM 
                advertisement a
            LEFT JOIN 
                bids b ON a.ad_id = b.ad_id
            LEFT JOIN 
                bidder bi ON b.ad_id = bi.ad_id
            LEFT JOIN 
                town t ON a.town_id = t.town_id
            LEFT JOIN 
                registered_user u ON a.nic = u.nic
            LEFT JOIN 
                images i ON a.ad_id = i.ad_id
            WHERE a.ad_id = :Ad_ID;';


    try{
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        echo "Error: " . $ex->getMessage();
    }
    }

    

}


?>
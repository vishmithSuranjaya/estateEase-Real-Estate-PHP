<?php

include_once 'User.php';
//require 'dbConnector.php';
//require_once 'Email.php';

class Admin extends User{
    private $useremail;
    private $password;
    private $newConfirmPassword;
    private $newPassword;
    private $currentPassword;
    private $id;
    private $username;
    private $town;
    private $contactNum;
    private $address;
    private $town_id;
    private $role;           //wheather admin or customer

    public function __construct($useremail) {
       $this->useremail = $useremail;
       
       $dbcon = new dbConnector();
       $con = $dbcon->getConnection();
       
        try {
            $sql = 'SELECT * FROM registered_user WHERE email = ?';
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $this->useremail);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            if ($pstmt->rowCount() > 0) {
                    $this->id = $row['nic'];
                    $this->username=$row['name'];
                    $this->role = $row['role'];
                    $this->contactNum= $row['contact_No'];
                    $this->password = $row['password'];
                    $this->address= $row['address'];
                    $this->town_id = $row['town_id'];
                }
                
            
        } catch (Exception $ex) {
            
        }
   }
    
    public function __destruct() {
        unset($this->useremail, $this->password, $this->confirmPassword, $this->id, $this->username, $this->town, $this->contactNum, $this->address, $this->town_id, $this->role);
    }

    
    //getters and setters 

    public function setUseremail($useremail){  //setter for email
        $this->useremail = $useremail;
    }
    public function setPassword($password){    //setter for password
        $this->password = $password;
    }
    public function setNewPassword($newPassword){    //setter for password
        $this->newPassword = $newPassword;
    }
    public function setNewConfirmPwd($newConfirmPassword){
        $this->newConfirmPassword = $newConfirmPassword;
    }
    
    
    
    public function idUser(){           //getter for nic
        return $this->id;
    }
    public function userEmail(){     //getter for email
        return $this->useremail;
    }
    
    public function userName(){    //getter for username
        return $this->username;
    }
    public function getRole(){
        return $this->role;       //getter function for role
    }
    public function getAddress(){
        return $this->address;       //getter function for role
    }
    
    public function getContact(){
        return $this->contactNum;
    }
    

    // function for getting the town of the admin

    public function getTown(){
        
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "
            SELECT t.town
            FROM town t
            INNER JOIN registered_user ru ON t.town_id = ru.town_id
            WHERE ru.nic = :admin_id
        ";

        try {
            $stmt = $con->prepare($query);
            $stmt->bindParam(':admin_id', $this->id, PDO::PARAM_INT); 
            $stmt->execute();
            $town = $stmt->fetchColumn(); 

            return $town;
        } catch (PDOException $e) {
            die("Error fetching town: " . $e->getMessage());
        }
    }
    
    //function for getting the district of the admin
    
    public function getDistrict(){
        
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "
            SELECT t.district
            FROM town t
            INNER JOIN registered_user ru ON t.town_id = ru.town_id
            WHERE ru.nic = :admin_id
        ";

        try {
            $stmt = $con->prepare($query);
            $stmt->bindParam(':admin_id', $this->id, PDO::PARAM_INT); 
            $stmt->execute();
            $district = $stmt->fetchColumn(); 

            return $district;
        } catch (PDOException $e) {
            die("Error fetching district: " . $e->getMessage());
        }
    }
    
    //validations for the password
    
    public function validatePassword()
    {
        if (preg_match('/(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).{8,24}/', $this->newPassword)) {
            return true;
        } else {
            return false;
        }
    }
    
    //function for checking the typed in password is the same password as in the record of the logged in admin
    public function checkPassword($currentPassword){
        $dbcon = new dbConnector;   
        $con = $dbcon->getConnection();
        $query = "SELECT * FROM registered_user WHERE email=?";
        
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->useremail);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);

            if ($pstmt->rowCount() > 0) {
                if(password_verify($currentPassword,$row['password'])){
                    
                    return true; 
                }
                else{
                    return false;
                }
              }
              else{
                return false; //user not registered
              }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    
    //function for checking if the newly entered password and the confirm password is the same
    public function passwordMatch()
    {
        if ($this->newPassword !== $this->newConfirmPassword) {
            return false;
        } else {
            return true;
        }
    }
    
    

    //function for checking if the email is already registered to the system
    public function registeredEmail(){
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "SELECT * FROM registered_user where email=?";

        try{
            $pstmt=$con->prepare($query);
            $pstmt->bindValue(1,$this->useremail);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
               if($pstmt->rowCount() > 0){
                return true;
               }
               else{
                return false;
               }
        }
        catch(PDOExceptio $e){
            die("Connection failed".$e->getMessage());
        }
    }
    
    //login function
    public function Login(){
        
        $dbcon = new dbConnector;   
        $con = $dbcon->getConnection();
        $query = "SELECT * FROM registered_user WHERE email=?";
        
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->useremail);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);

            if ($pstmt->rowCount() > 0) {
                if($this->password == $row['password']){
                    $this->id = $row['nic'];
                    $this->username=$row['name'];
                    $this->role = $row['role'];
                    return 1; //login successfull
                }
                else{
                    return 10; //wrong password
                }
              }
              else{
                return 100; //user not registered
              }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        
      }



   


   // change password

   public function changePassword(){
        
    
         $dbcon = new dbConnector();
            $con = $dbcon->getConnection();
            $query = "UPDATE registered_user SET password=? where nic=?";
            try{
                  
                $stmt = $con->prepare($query);
                $stmt->bindValue(1,password_hash($this->newPassword,PASSWORD_BCRYPT));
                $stmt->bindValue(2,$this->id);
                $stmt->execute();
                
              }catch(PDOException $e){
                die("Connection failed!".$e->getMessage());
              }
   }

   //forgot password
    public function forgotPassword(){    //remember to destroy the session here or unset session['otp']
      echo "called";
    }
  
    //function for viewing the details of a user inside the admin panel
    public function viewUser($nic,$rowNumber){

        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT ru.nic, ru.name, ru.email, ru.password, ru.contact_No, t.district, t.town, ru.verification_doc
                FROM registered_user ru
                JOIN town t ON ru.town_id = t.town_id
                WHERE ru.nic = :nic';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo '<div class="user-details-container">
                    <h2>- Details of the User -</h2>
                    <table class="user-details">
                        <tr>
                            <td><b>1) NIC Number : </b></td>
                            <td>' . htmlspecialchars($user['nic']) . '</td>
                            <td><b>8) Verification Document : </b></td>
                        </tr>
                        <tr>
                            <td><b>2) Name : </b></td>
                            <td>' . htmlspecialchars($user['name']) . '</td>
                            <td rowspan="6">
                                <div class="user-verification">';
            if (!empty($user['verification_doc'])) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->buffer($user['verification_doc']);
                echo '<img src="data:' . $mimeType . ';base64,' . base64_encode($user['verification_doc']) . '" alt="Verification Document" class="doc">';
            } else {
                echo '<p>No Verification Document Available</p>';
            }
            echo '          </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>3) Email : </b></td>
                            <td>' . htmlspecialchars($user['email']) . '</td>
                        </tr>
                        <tr>
                            <td><b>5) Contact Number : </b></td>
                            <td>' . htmlspecialchars($user['contact_No']) . '</td>
                        </tr>
                        <tr>
                            <td><b>6) Residing District : </b></td>
                            <td>' . htmlspecialchars($user['district']) . '</td>
                        </tr>
                        <tr>
                            <td><b>7) Residing Town : </b></td>
                            <td>' . htmlspecialchars($user['town']) . '</td>
                        </tr>
                    </table>
                    <div class="button-group">
                        <button class="close-btn">Close</button>
                        <button class="btn btn-sm btn-secondary UD" id="banUserBtn" onclick="popupBanUser(' . $rowNumber . ')">Ban</button>
                    </div>
                  </div>';
        } else {
            echo '<h3 style="color:red">User not found!</h3>';
            echo '</br><button class="close-btn">Close</button>';
        }


    }
    
    //function for viewing A specific bid ad
    public function viewBidAd($Ad_ID){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = "SELECT 
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
                WHERE a.ad_id = :Ad_ID AND a.category != 'hidden';";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    
    //function for viewing non bid ad
    public function viewNonBidAd($Ad_ID){
        
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = "SELECT 
                    a.*, 
                    t.town AS town, 
                    t.district AS district, 
                    u.name AS name, 
                    u.email AS email, 
                    u.contact_No AS originalContact,
                    i.image1 as image1, 
                    i.image2 as image2, 
                    i.image3 as image3, 
                    i.image4 as image4, 
                    i.image5 as image5
                FROM 
                    advertisement a
                JOIN 
                    town t ON a.town_id = t.town_id
                JOIN 
                    registered_user u ON a.nic = u.nic
                LEFT JOIN 
                    images i ON a.ad_id = i.ad_id
                WHERE a.ad_id = :Ad_ID AND a.category != 'hidden';";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
        $stmt->execute();
        return $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    //logout function of the admin
    public function logout(){
        $_SESSION = [];
        unset($_SESSION['status']);
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }
    
    //function for inserting bid ad information to their respective tables in the database
    public function Advertisement_approve($Ad_ID){
        try {
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();
        
        $con->beginTransaction();
        
        $query1 = "INSERT INTO advertisement(nic, town_id, land_Area, longitude, latitude, contact_No, price, type, description, title, category, no_of_bedrooms, no_of_bathrooms, no_of_floors, floor_area)
                   SELECT nic, town_id, land_Area, longitude, latitude, contact_No, price, type, description, title, category, no_of_bedrooms, no_of_bathrooms, no_of_floors, floor_area
                   FROM pending_ad_approval
                   WHERE ad_id = :Ad_ID";
        
        $stmt = $con->prepare($query1);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_INT);
        $stmt->execute();
        echo ('1');
        
        $lastAdId = $con->lastInsertId();
        echo $lastAdId;
        $query2 = "INSERT INTO bids(ad_id, verify_doc, end_time, min_auc_price)
                   SELECT :lastAdId, verify_doc, end_time, min_auc_price
                   FROM pending_ad_approval
                   WHERE ad_id = :Ad_ID";
        
        $stmt = $con->prepare($query2);
        $stmt->bindParam(':lastAdId', $lastAdId, PDO::PARAM_INT);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_INT);
        $stmt->execute();
        echo ('2');
        
        $query3 = "INSERT INTO images(ad_id, image1, image2, image3, image4, image5)
                   SELECT :lastAdId, image1, image2, image3, image4, image5
                   FROM pending_ad_approval
                   WHERE ad_id = :Ad_ID";
        
        $stmt = $con->prepare($query3);
        $stmt->bindParam(':lastAdId', $lastAdId, PDO::PARAM_INT);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_INT);
        $stmt->execute();
        echo ('3');
        
        $query5 = "INSERT INTO bidder (ad_id)
                    SELECT :lastAdId;";
        
              
        $stmt = $con->prepare($query5);
        $stmt->bindParam(':lastAdId', $lastAdId, PDO::PARAM_INT); 
        $stmt->execute();
        echo ('5');
        
        $query4 = "DELETE FROM pending_ad_approval where ad_id = :Ad_ID;";
        
        $stmt = $con->prepare($query4);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_INT);
        $stmt->execute();
        echo ('4');
        $con->commit();
        
        echo "Success";
        
        } catch (PDOException $ex) {
            $con->rollBack();
            http_response_code(500); 
            echo "Database Error: " . $ex->getMessage();
        }
    }
    
    //function for moving signed up users to registered_user table once they have been approved by the admin
    public function userAccount_approve($nic){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $con->beginTransaction();

            $queries = [
                "DELETE FROM registered_user WHERE nic = :nic;",
                
                "INSERT INTO registered_user (nic, name, email, contact_No, address, password, verification_doc, town_id, role)
                SELECT nic, name, email, contact_No, address, password, verification_doc, town_id, role
                FROM pending_user_approval
                WHERE nic = :nic;",

                "DELETE FROM pending_user_approval
                WHERE nic = :nic;"
                ];
            $row=1;
            foreach ($queries as $query) {
                $stmt = $con->prepare($query);
                $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
                $stmt->execute();
                echo "$row";
                $row++;
            }

            $con->commit();

            echo"success";

        } catch (PDOException $ex) {
            $con->rollBack();
            http_response_code(500); 
            echo "Database Error: " . $ex->getMessage();
        }
    }
    
    //function for banning users from the admin panel
    public function ban_users($nic){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $sql =  "UPDATE registered_user SET status = 'Blacklisted' WHERE nic = :nic";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
            $stmt->execute();


        } catch (PDOException $ex) {
            http_response_code(500);
            echo "Database Error: " . $ex->getMessage();
        }
    }
    
    //function for removing the ban from the users in the admin panel
    public function remove_ban($nic){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $sql =  "UPDATE registered_user SET status = 'No Issues' WHERE nic = :nic";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
            $stmt->execute();


        } catch (PDOException $ex) {
            http_response_code(500);
            echo "Database Error: " . $ex->getMessage();
        }
    }
    
    //function for removing the ads from the system from by the admin
    public function remove_ad_database($Ad_ID){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $con->beginTransaction();

            $queries = [
                "DELETE 
                FROM payment 
                WHERE ad_id = :Ad_ID;",


                "DELETE FROM advertisement
                WHERE ad_id = :Ad_ID;"
                ];
            $row=1;
            foreach ($queries as $query) {
                $stmt = $con->prepare($query);
                $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_INT);
                $stmt->execute();

            }

            $con->commit();

            echo"success";

        } catch (PDOException $ex) {
            $con->rollBack();
            http_response_code(500); 
            echo "Database Error: " . $ex->getMessage();
        }
    }
    
    //function for removing selected users from the system
    public function remove_user($nic){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $con->beginTransaction();

            $queries = [
                "DELETE 
                FROM payment 
                WHERE nic = :nic;",

                "DELETE FROM bidder
                WHERE nic = :nic;",

                "DELETE FROM registered_user
                WHERE nic = :nic;"
                ];
            $row=1;
            foreach ($queries as $query) {
                $stmt = $con->prepare($query);
                $stmt->bindParam(':nic', $nic, PDO::PARAM_INT);
                $stmt->execute();

            }

            $con->commit();

            echo"success";

        } catch (PDOException $ex) {
            $con->rollBack();
            http_response_code(500); 
            echo "Database Error: " . $ex->getMessage();
        }
    }
    
    //function for viewing ads in the ads approval page
    public function viewAdApproval(){
        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT 
                    a.ad_id as Ad_ID,
                    t.district as District,
                    t.town as Town,
                    a.title as Title,
                    a.category as Category
                FROM 
                    pending_ad_approval a
                JOIN 
                    town t ON a.town_id = t.town_id;

                ';
        $result = $con->query($sql);
        return $result;
    }
    
    //function to get the total count of signed up users in the pending user table
    public function totalUsersCount(){
        try {
            
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $sql = 'SELECT COUNT(*) AS total_records FROM pending_user_approval;';
            $result = $con->query($sql);

            if ($result) {
                $row = $result->fetch(PDO::FETCH_ASSOC);
                echo $row['total_records'];
            } else {
                echo 'Query failed.';
            }

        } catch (PDOException $ex) {
            echo 'Database Error: ' . $ex->getMessage();
        }
    }
    
    //function to get the total count of pending bid ads in the pending ad approval table
    public function TotalPendingBidAdCount(){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
            $sql2 = 'SELECT COUNT(*) AS total_records FROM pending_ad_approval;';
            $result2 = $con->query($sql2);

            if ($result2) {
                $rows = $result2->fetch(PDO::FETCH_ASSOC);
                echo $rows['total_records'];
            } else {
                echo 'Query failed.';
            }

        } catch (PDOException $ex) {
            echo 'Database Error: ' . $ex->getMessage();
        }
    }
    
    //function to get the information of the non blacklisted users in the system.
    public function banUserTable(){
        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = "SELECT nic,name,email,contact_No FROM registered_user WHERE status='No Issues'";
        $result = $con->query($sql);
        return $result;
    }
    
    //function to view details of the bid ads
    public function viewBidAds(){
        

        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT 
                    a.ad_id as Ad_ID,
                    t.district as District,
                    t.town as Town,
                    a.title as Title,
                    a.category as Category
                FROM 
                    advertisement a
                JOIN 
                    town t ON a.town_id = t.town_id
                JOIN 
                    bids b ON a.ad_id = b.ad_id;
                ';
        $result = $con->query($sql);
        return $result;
    }
    
    //function used in the analytics section to sort our the analytics
    public function viewAnalytics(){


        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT t.district AS district, 
                        COUNT(DISTINCT a.ad_id) as ads,
                        COUNT(DISTINCT u.nic) as users 
                 FROM town t
                 LEFT JOIN advertisement a ON a.town_id = t.town_id
                 LEFT JOIN registered_user u ON u.town_id = t.town_id
                 GROUP BY t.district
                 HAVING ads > 0 OR users > 0;';
        try {
            $query = $con->prepare($sql);
            $query->execute();

            $data =[];
            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row;
            }
            echo json_encode($data);
        } catch (Exception $ex) {
            die("Error fetching data: " . $ex->getMessage());
        }

    }
    
    //function to view non bid ads
    public function viewNonBidAds(){

        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = "SELECT 
                    a.ad_id as Ad_ID,
                    t.district as District,
                    t.town as Town,
                    a.title as Title,
                    a.category as Category
                FROM 
                    advertisement a
                JOIN 
                    town t ON a.town_id = t.town_id
                LEFT JOIN 
                    bids b ON a.ad_id = b.ad_id
                WHERE 
                    b.ad_id IS NULL AND a.category != 'hidden';
                ";
        $result = $con->query($sql);
        return $result;
    }
    
    //function to view the details of the all users in the system
    public function viewRemoveUsers(){
        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT nic,name,email,contact_No FROM registered_user';
        $result = $con->query($sql);
        return $result;
    }
    //function to view the details of the signed up users in the pending user approval table
    public function viewPendingUsers(){

        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT nic,name,email,contact_No FROM pending_user_approval;';
        $result = $con->query($sql);
        return $result;
                
    }
    //function to view all the details of the signed up users in the pending user approval table
    public function viewUserApprovalDetails($nic){

        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT ru.nic, ru.name, ru.email, ru.password, ru.contact_No, t.district, t.town, ru.verification_doc 
                FROM pending_user_approval ru
                JOIN town t ON ru.town_id = t.town_id
                WHERE ru.nic = :nic';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //function to check if the user is banned in the system
    public function inBannedList($nic){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();
            
            $stmt = $con->prepare("SELECT status FROM registered_user WHERE nic = :nic AND status = 'Blacklisted'");
            $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $ex) {
            die("error checking the banned List " . $ex->getMessage());
        }
    }
    //function to view the details of the blacklisted users in the system
    public function viewBannedUserDetails($nic){

        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = "SELECT ru.nic, ru.name, ru.email, ru.password, ru.contact_No, t.district, t.town, ru.verification_doc,ru.status 
                FROM registered_user ru
                JOIN town t ON ru.town_id = t.town_id
                WHERE ru.nic = :nic && status='Blacklisted'";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //function to view all the details of the users in the system which are not blacklisted
    public function viewUserRemoveDetails($nic){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT ru.nic, ru.name, ru.email, ru.password, ru.contact_No, t.district, t.town, ru.verification_doc
                FROM registered_user ru
                JOIN town t ON ru.town_id = t.town_id
                WHERE ru.nic = :nic';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':nic', $nic, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //function to view the users who have been blacklisted in the system
    public function viewBlacklisted(){
        

        $dbcon= new Dbconnector();
        $con = $dbcon->getConnection();

        $sql = "SELECT * FROM registered_user WHERE status = 'Blacklisted';
                ";
        $result = $con->query($sql);
        return $result;
    }
    //function to view all the details of the pending bid ad in the admin panel
    public function viewApprovalAdAdmin($Ad_ID){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql = 'SELECT 
            a.*, 
            t.town AS town, 
            t.district AS district, 
            u.name AS name, 
            u.email AS email, 
            u.contact_No AS originalContact
        FROM 
            pending_ad_approval a
        JOIN 
            town t ON a.town_id = t.town_id
        JOIN 
            registered_user u ON a.nic = u.nic
                WHERE a.ad_id = :Ad_ID;';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //function to check if the ad is a bid ad or not
    public function bidCheck($Ad_ID){

        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();

        $sql9 = 'SELECT EXISTS (SELECT 1 FROM bids WHERE ad_id = :Ad_ID) AS record_exists;';
        $stmt = $con->prepare($sql9);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    //function to view the details of the bid ad
    public function bidCehckedView($Ad_ID){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();
        $sql = "SELECT 
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
                JOIN 
                    bids b ON a.ad_id = b.ad_id
                JOIN 
                    bidder bi ON b.ad_id = bi.ad_id
                JOIN 
                    town t ON a.town_id = t.town_id
                JOIN 
                    registered_user u ON a.nic = u.nic
                LEFT JOIN 
                    images i ON a.ad_id = i.ad_id
                WHERE a.ad_id = :Ad_ID AND a.category != 'hidden';";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //function to view the details of the non bid ad
    public function nonbidCheckedView($Ad_ID){
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();
        $sql = "SELECT 
            a.*, 
            t.town AS town, 
            t.district AS district, 
            u.name AS name, 
            u.email AS email, 
            u.contact_No AS originalContact,
            i.image1 as image1, 
            i.image2 as image2, 
            i.image3 as image3, 
            i.image4 as image4, 
            i.image5 as image5
        FROM 
            advertisement a
        JOIN 
            town t ON a.town_id = t.town_id
        JOIN 
            registered_user u ON a.nic = u.nic
        LEFT JOIN 
            images i ON a.ad_id = i.ad_id
        WHERE a.ad_id = :Ad_ID AND a.category != 'hidden';";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    //function to delete the pending bid ad from the system.
    public function Advertisement_decline($Ad_ID){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $sql = "DELETE FROM pending_ad_approval WHERE ad_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $Ad_ID, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $ex) {
            http_response_code(500);
            echo "Database Error: " . $ex->getMessage();
        }
    }
    //function to delete the pending users from the system.
    public function userAccount_decline($nic){
        try {
            $dbcon = new DbConnector();
            $con = $dbcon->getConnection();

            $sql = "DELETE FROM pending_user_approval WHERE nic = ?";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $nic, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $ex) {
            http_response_code(500);
            echo "Database Error: " . $ex->getMessage();
        }
    }
}

  



?>
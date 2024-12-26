<?php 

require 'dbConnector.php';
require_once 'Email.php';

class User{
    private $useremail;
    private $password;
    private $confirmPassword;
    private $id;
    private $username;
    private $town;
    private $district;
    private $address;
    private $contactNum;
    private $otp;
    private $myOtp;
    private $image;
    private $town_id;
    //constructor of the user class
    public function __construct($username,$id,$email,$password,$confirmpassword,$address,$town,$district,$contactNum,$otp,$myOtp,$image){
        $this->username = $username;
        $this->id = $id;
        $this->useremail = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmpassword;
        $this->address = $address;
        $this->town = $town;
        $this->district = $district;
        $this->contactNum = $contactNum;
        $this->otp = $otp;
        $this->myOtp = $myOtp;
        $this->image = $image;
    }

    //getters and setters
    public function setUseremail($useremail){
        $this->useremail = $useremail;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    
    public function idUser(){
        return $this->id;
    }
    
    public function userName(){
        return $this->username;
    }
    public function setmyOtp($myOtp){
        $this->myOtp = $myOtp;
    }
    public function getOtp(){
        return $this->otp;
    }
    public function setOtp($otp){
        $this->otp = $otp;
    }
    public function getmyOtp(){
        return $this->myOtp;
    }
    //validating inputs for registration

    //validating nic
    public function validateNic(){
        if (preg_match('/^(?:\d{12}|\d{9}[vV])$/', $this->id)){
            return true;
        } else {
            return false;
        }
    }

    //validate username
    public function validateUsername(){
        if (preg_match('/^[a-z]{1,15}$/', $this->username)) {
            return true;
        } else {
            return false;
        }
    }

    //validate contct number
    public function validateTelephone()
    {
        if (preg_match('/^0\d{9}$/', $this->contactNum)) {
            return true;
        } else {
            return false;
        }
    }
    
    //validate email
    public function validateEmail()
    {
        if (filter_var($this->useremail, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    //validate password
    public function validatePassword()
    {
        if (preg_match('/(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).{8,24}/', $this->password)) {
            return true;
        } else {
            return false;
        }
    }
    //function for checking if the entered password is the same as the confirm password
    public function passwordMatch()
    {
        if ($this->password !== $this->confirmPassword) {
            return false;
        } else {
            return true;
        }
    }
    //function for confirming the otp with the sent otp
    public function otpMatch(){
        if($this->otp == $this->myOtp){
            return true;
        }
        else{
            return false;
        }
    }
    //checking whether the email is already exists
    public function invalidEmail()
    {
        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        $query = "SELECT * FROM registered_user WHERE email = ?;";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->useremail);
            $pstmt->execute();
            $rs = $pstmt->fetch(PDO::FETCH_ASSOC);

            if ($pstmt->rowCount() > 0) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // checking wheather the user in banned before (NIC is used to this procedure)
    public function checkRegistered_userList(){
    $dbcon = new dbConnector;
    $con = $dbcon->getConnection();
    $query = "SELECT * FROM registered_user WHERE nic = ? && status = 'No Issues'";
    
    try {
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->id);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_ASSOC);

        if ($pstmt->rowCount() > 0) {
            return false; // User is in the registered_user table
        } else {
            return true;  // User is not in the registered_user table
        }
    } catch (PDOException $e) {
        die("Connection failed! " . $e->getMessage());
    }
}
//function for checking the if the user is in the pending user approval table of not 
public function checkPending_userTable(){
    $dbcon = new dbConnector;
    $con = $dbcon->getConnection();
    $query = "SELECT * FROM pending_user_approval WHERE nic = ?";
    
    try {
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->id);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_ASSOC);

        if ($pstmt->rowCount() > 0) {
            return false; // User is in the pending_user_approval table
        } else {
            return true;  // User is not in the pending_user_approval table
        }
    } catch (PDOException $e) {
        die("Connection failed! " . $e->getMessage());
    }
}


    

    //when validation of the user input is over submitting for admin approval to 'pending_user_approval' table
    public function register($hashedPwd){
         
        $dbcon = new dbConnector;
        $con = $dbcon->getconnection();
        // 01 - get the town_id from town tabel to update the registered_user table
        $query1 = "SELECT town_id from  town where town=?";
        
        try{
            $stmt = $con->prepare($query1);
            $stmt->bindValue(1,$this->town);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->town_id = $row["town_id"];
        }catch(PDOException $e){
           die("Connection failed!".$e->getMessage());
        }
        
        $query = "INSERT INTO pending_user_approval (nic, name, email, contact_No, address, password, verification_doc, town_id, role) 
                   VALUES (?,?,?,?,?,?,?,?,?)";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1,$this->id);
            $pstmt->bindValue(2,$this->username);
            $pstmt->bindValue(3,$this->useremail);
            $pstmt->bindValue(4,$this->contactNum);
            $pstmt->bindValue(5,$this->address);
            $pstmt->bindValue(6,$hashedPwd);
            $pstmt->bindParam(7,$this->image,PDO::PARAM_LOB); 
            $pstmt->bindValue(8,$this->town_id);
            $pstmt->bindValue(9,'customer');
            
            if($pstmt->execute()){
                return true;
            }
            
            
            
        } catch (Exception $ex) {
            die("Databse insert error!".$ex->getMessage());
        }

    }

    
    function generateAndSendOTP($otpemail) {
        
            
            // Generate OTP (4-digit random number)
            $this->myOtp = mt_rand(1000, 9999);
    
            $subject = "OTP for registration";
            $obj = new Mail;
            $obj->sendMail($otpemail, $subject, $this->myOtp);
            echo "send";
 }
      
    
}
?>
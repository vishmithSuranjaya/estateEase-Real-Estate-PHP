<?php

include_once 'User.php';

//require 'dbConnector.php';
//require_once 'Email.php';

class Registered_user extends User {

    private $useremail;
    private $password;
    private $confirmPassword;
    private $id;
    private $username;
    private $town;
    private $district;
    private $contactNum;
    private $address;
    private $town_id;
    private $role;           //wheather admin or customer

    public function __construct() {
        
    }

    public function __destruct() {
        unset($this->useremail, $this->password, $this->confirmPassword, $this->id, $this->username, $this->town, $this->contactNum, $this->address, $this->town_id, $this->role);
    }

    public function setNic($nic) {        //setter for nic
        $this->id = $nic;
    }

    public function setUseremail($useremail) {  //setter for email
        $this->useremail = $useremail;
    }

    public function setPassword($password) {    //setter for password
        $this->password = $password;
    }

    public function setConfirmPwd($confirmPassword) {
        $this->confirmPassword = $confirmPassword;
    }

    public function setUsername($username) {   // setter for username;
        $this->username = $username;
    }

    public function setContactNum($contactNum) { //setter for contact number
        $this->contactNum = $contactNum;
    }

    public function setAddress($address) {  //setter for address
        $this->address = $address;
    }

    public function idUser() {           //getter for nic
        return $this->id;
    }

    public function userEmail() {     //getter for email
        return $this->useremail;
    }

    public function userName() {    //getter for username
        return $this->username;
    }

    function getUseremail() {
        return $this->useremail;
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getTown() {
        return $this->town;
    }

    function getDistrict() {
        return $this->district;
    }

    function getContactNum() {
        return $this->contactNum;
    }

    function getAddress() {
        return $this->address;
    }

    function getTown_id() {
        return $this->town_id;
    }

    public function getRole() {
        return $this->role;       //getter function for role
    }

    public function setTown($town) {      //setter for town
        $this->town = $town;
    }

    //validating inputs for registration
    //validate email
    public function validateEmail() {
        if (filter_var($this->useremail, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    //validate username
    public function validateUsername() {
        if (preg_match('/^[a-z\s]{1,15}$/i', $this->username)
        ) {
            return true;
        } else {
            return false;
        }
    }

    //validate contct number
    public function validateTelephone() {
        if (preg_match('/^0\d{9}$/', $this->contactNum)) {
            return true;
        } else {
            return false;
        }
    }

    //validate otp
    public function validateOtp($otp) {
        if (preg_match('/^[1-9]\d{3}$/', $otp)) {
            return true;
        } else {
            return false;
        }
    }

    //validate password
    public function validatePassword() {
        if (preg_match('/(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).{8,24}/', $this->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function passwordMatch() {
        if ($this->password !== $this->confirmPassword) {
            return false;
        } else {
            return true;
        }
    }

    //validate address
    public function validateAddress() {
        if (preg_match("/^[a-zA-Z0-9,'\/.\s]{1,100}$/", $this->address)) {
            return true;
        } else {
            return false;
        }
    }

    //checking whether email exits
    public function registeredEmail() {
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "SELECT * FROM registered_user where email=?";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->useremail);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            if ($pstmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOExceptio $e) {
            die("Connection failed" . $e->getMessage());
        }
    }

    //login function
    public function Login() {
        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        $query = "SELECT * FROM registered_user WHERE email=?";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->useremail);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $row = $pstmt->fetch(PDO::FETCH_ASSOC);
                $hashedPwd = $row['password'];

                if (password_verify($this->password, $hashedPwd)) {
                    $this->id = $row['nic'];
                    $this->username = $row['name'];
                    $this->role = $row['role'];
                    return 1; //login successful
                } else {
                    return 10; //wrong password
                }
            } else {
                return 100; //user not registered
            }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // update registered user account details
    public function updateUserDetails() {

        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        // 01 - get the town_id from town tabel to update the registered_user table
        $query1 = "SELECT town_id from  town where town=?";

        try {
            $stmt = $con->prepare($query1);
            $stmt->bindValue(1, $this->town);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->town_id = $row["town_id"];
        } catch (PDOException $e) {
            die("Connection failed!" . $e->getMessage());
        }


        // 02 - update the registered_user table updating name,contact_no,address,district,town
        $query2 = "UPDATE registered_user SET name=?,contact_No=?,address=?,town_id=? where nic=?";
        try {

            $stmt = $con->prepare($query2);
            $stmt->bindValue(1, $this->username);
            $stmt->bindValue(2, $this->contactNum);
            $stmt->bindValue(3, $this->address);
            $stmt->bindValue(4, $this->town_id);
            $stmt->bindValue(5, $this->id);
            $stmt->execute();


            echo "<script>alert('Saved Changes succesfully!')</script>";

            header("Location: ./user_dashboard.php");

            // $stmt->bindValue(4,$townid);
        } catch (PDOException $e) {
            die("Connection failed!" . $e->getMessage());
        }
    }

    // change password

    public function changePassword() {


        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "UPDATE registered_user set password=? where nic=?";
        try {

            $stmt = $con->prepare($query);
            $stmt->bindValue(1, password_hash($this->password, PASSWORD_BCRYPT));
            $stmt->bindValue(2, $this->id);
            $stmt->execute();
            echo "<script>alert('Saved Changes succesfully!')</script>";
        } catch (PDOException $e) {
            die("Connection failed!" . $e->getMessage());
        }
    }

    //forgot password
    public function forgotPassword($hashedPwd) {    //remember to destroy the session here or unset session['otp']
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "UPDATE registered_user set password=? where email=?";
        try {
            $stmt = $con->prepare($query);
            $stmt->bindValue(1, $hashedPwd);
            $stmt->bindValue(2, $this->useremail);
            $stmt->execute();
            echo "<script>alert('Saved Changes succesfully!')</script>";
        } catch (PDOException $e) {
            die("Connection failed!" . $e->getMessage());
        }
    }

    //function for assining the details of the user to the object made .
    public function getUserDetailsByNIC($nic) {
        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        $query = "SELECT * FROM registered_user WHERE nic = ?";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $nic);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $row = $pstmt->fetch(PDO::FETCH_ASSOC);
                $this->id = $row['nic'];
                $this->username = $row['name'];
                $this->useremail = $row['email'];
                $this->address = $row['address'];
                $this->town_id = $row['town_id'];
                $this->contactNum = $row['contact_No'];
                $this->password = $row['password'];

                $query23 = "SELECT * FROM town WHERE town_id = ?";

                try {
                    $pstmt = $con->prepare($query23);
                    $pstmt->bindValue(1, $this->town_id);
                    $pstmt->execute();

                    if ($pstmt->rowCount() > 0) {
                        $row = $pstmt->fetch(PDO::FETCH_ASSOC);
                        $this->town = $row['town'];
                        $this->district = $row['district'];
                    }
                } catch (Exception $ex) {
                    die("Error: " . $e->getMessage());
                }
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    //function for inserting the ad payment details when posting a bid ad to the system
    public function adPostingPayment($nic) {
        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        $sql = "INSERT INTO payment(nic,amount) VALUES (?,?)";

        try {
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $nic);
            $pstmt->bindValue(2, 3000);
            $pstmt->execute();
        } catch (Exception $ex) {
            die("Connection failed!" . $e->getMessage());
        }
    }

    //function for inserting the payment details of the advance money payment in the property reserving instance
    public function auctionAdvancePayment($nic, $ad_id) {
        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        $sql = "INSERT INTO payment(nic,ad_id,amount) VALUES (?,?,?)";

        try {
            $pstmt = $con->prepare($sql);
            $pstmt->bindValue(1, $nic);
            $pstmt->bindValue(2, $ad_id);
            $pstmt->bindValue(3, 20000);
            $pstmt->execute();
        } catch (Exception $ex) {
            die("Connection failed!" . $e->getMessage());
        }
    }

    //logout function
    public function logout() {

        $_SESSION = [];
        unset($_SESSION['status']);
        session_unset();
        session_destroy();
        header("Location: index.php");
        ;
    }

}

?>
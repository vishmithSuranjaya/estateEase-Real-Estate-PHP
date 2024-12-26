<?php

//use PDO;
//use PDOException;


class dbConnector{
    private $host = "localhost";
    private $dbname = 'estateease'; //enter the name of the database
    private $dbuser = "estateEase"; //try to change the database user hense for the security purposes
    private $dbpass = "estateEase"; //enter the password accoring to created account
    

    public function getConnection(){
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";";

        try {
            $con = new PDO($dsn, $this->dbuser, $this->dbpass);
            return $con;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
            
        }
    }
}
//completed by now. edit database details
?>
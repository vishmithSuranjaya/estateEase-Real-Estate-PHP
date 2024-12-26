<?php

require_once 'dbConnector.php';

class Advertisement {
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
    //constructor
    public function __construct($category,$type,$no_of_bedrooms,$no_of_bathrooms,$no_of_floors,$floorArea,$landArea,$title,$description,$price,$district,$town,$contactNo,$logitude,$lattitude,$image1,$image2,$image3,$image4,$image5) {
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
        $this->longitude = $logitude;
        $this->latitude = $lattitude;
        $this->image01 = $image1;
        $this->image02 = $image2;
        $this->image03 = $image3;
        $this->image04 = $image4;
        $this->image05 = $image5;
    }
    //validation functions
    public function validatePrice($price){                                         //validating price entered by the user
        if (preg_match('/^(Rs|rs)?\s*\d{1,3}(?:,?\d{3})*(?:\.\d{2})?$/', $price)){      //  Rs 100.50 , rs 50  are valid 
            return true;                                                      // 99.999 is not valid
        } else {
            return false;
        }
        
    }
    public function validateNumbers($num){
        if(preg_match('/^(0|[1-9]\d?)$/',$num)){
            return true;
        }else{
            return false;
        }
    }

    public function validateDesc($description){
        if(preg_match('/^[a-zA-Z0-9][a-zA-Z0-9\s,.\-]{9,}$/',$description)){      //validating description 
            return true;                                                               //minimum 10 charactors
        }else{
            return false;
        }
    }

    public function validateArea($area){                               //validating area. can contain numbers.no values<0
        if(preg_match('/^\d+(\.\d+)?$/',$area)){
            return true;
        }else{
            return false;
        }
    }
    public function validateTelephone($contactNo)
    {
        if (preg_match('/^0\d{9}$/', $contactNo)) {
            return true;
        } else {
            return false;
        }
    }
    
//function for posting a fixed or rent ad to the system
    public function postAdd(){    // sending advertisement table
        
        $nic = $_SESSION['id'];
        echo $nic;

        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();

        $query1 = "SELECT * FROM town WHERE town = ?";  //getting town_id from the town table by entering town
        try{
            $pstmt = $con->prepare($query1);
            $pstmt->bindValue(1,$this->town);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);

            $town_id = $row['town_id'];
        }catch(PDOException $e){
            die("Connection failed".$e->getMessage());
        }


       $query2 = "INSERT INTO advertisement(nic,town_id,land_Area,longitude,latitude,contact_No,price,type,description,title,category,no_of_bedrooms,no_of_bathrooms,no_of_floors,floor_area) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";   //verification img and the images are not added

        try{
            $pstmt = $con->prepare($query2);
            $pstmt->bindValue(1,$_SESSION['id']);
            $pstmt->bindValue(2,$town_id);
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
                                                          //verification doc not binned
            $pstmt->execute();
            // Check if insertion was successful
            
            //
            if ($pstmt->rowCount() > 0) {
                
                $lastAdId = $con->lastInsertId();
                
                $query3 = 'INSERT INTO images (ad_id,image1,image2,image3,image4,image5) VALUES (?,?,?,?,?,?)';
                $pstmt1 = $con->prepare($query3);
                $pstmt1->bindValue(1,$lastAdId);
                $pstmt1->bindParam(2,$this->image01,PDO::PARAM_LOB);
                $pstmt1->bindParam(3,$this->image02,PDO::PARAM_LOB);
                $pstmt1->bindParam(4,$this->image03,PDO::PARAM_LOB);
                $pstmt1->bindParam(5,$this->image04,PDO::PARAM_LOB);
                $pstmt1->bindParam(6,$this->image05,PDO::PARAM_LOB);
                
                $pstmt1->execute();
                 
                
                return true;
            } else {
                return false;
            }
        
        }catch(PDOException $e){
            die("Connection Failed!".$e->getMessage());
        }
        
        
    }
    
    
    
    
    
}



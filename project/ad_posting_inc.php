<?php
//require_once './classes/Advertisement.php';
require_once './classes/BidAds.php';

if(isset($_POST['submit'])){
    $category = $_POST['category'];
    $type = $_POST['type'];
    $no_of_bedrooms = strip_tags($_POST['no_rooms']);
    $no_of_bathrooms = strip_tags($_POST['no_bath']);
    $no_of_floors = strip_tags($_POST['no_floors']);
    $floorArea = strip_tags($_POST['floorArea']);
    $area = strip_tags($_POST['area']);
    $area_unit = $_POST['area_unit'];
    $title = strip_tags($_POST['title']);
    $description = strip_tags($_POST['description']);
    $price = strip_tags($_POST['price']);
    $district = $_POST['district'];
    $town = $_POST['town'];
    $contactNo = $_POST['contactNo'];
    $lattitude = $_POST['lattitude'];
    $logitude = $_POST['longitude'];
    
    
    function validateImage($imageName){
        if (isset($_FILES[$imageName]) && $_FILES[$imageName]['error'] == UPLOAD_ERR_OK){
            $file_tmp = $_FILES[$imageName]['tmp_name'];
            $file_name = $_FILES[$imageName]['name'];
            $file_size = $_FILES[$imageName]['size'];
            $file_type = $_FILES[$imageName]['type'];
            
            $allowedTypes = array('image/jpeg', 'image/jpg', 'image/png');
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($file_info, $file_tmp);
            finfo_close($file_info);
            
            if(!in_array($mime_type, $allowedTypes)){
                return false;
            }
            
            $maxFile_Size = 5 * 1024 * 1024;    // (max is 5mb)
            if($file_size > $maxFile_Size){
                return false;
            }
            
            return file_get_contents($file_tmp);
        }
        return NULL;
        
    }
    
    $image1 = validateImage('img01') !== false ? validateImage('img01') : NULL;
    $image2 = validateImage('img02') !== false ? validateImage('img02') : NULL;
    $image3 = validateImage('img03') !== false ? validateImage('img03') : NULL;
    $image4 = validateImage('img04') !== false ? validateImage('img04') : NULL;
    $image5 = validateImage('img05') !== false ? validateImage('img05') : NULL;
    
    
    
    

    
    
    $landArea = $area .''. $area_unit;
    //selecting category
    if($category == "Auction"){
        if(!empty($_POST['min_auc_price']) && !empty($_POST['date']) && !empty($_POST['time'])){
            $minPrice = strip_tags($_POST['min_auc_price']);
            $date =$_POST['date'];
            $time =$_POST['time'];
            $timePeriod = $date . ' ' . $time;
            $verification_doc = validateImage('validDoc') !== false ? validateImage('validDoc') : NULL;
            
            //valid document of the property uploading comes here
            $ad = new BidAdds($category,$type,$no_of_bedrooms,$no_of_bathrooms,$no_of_floors,$floorArea,$landArea,$title,$description,$price,$district,$town,$contactNo,$minPrice,$timePeriod,$logitude,$lattitude,$verification_doc,$image1,$image2,$image3,$image4,$image5);       //object of the BidAdds class

            if(!($ad->validatePrice($price))){
                header("Location: Ad_posting_form.php?status=1");
                
            }else if(!($ad->validatePrice($minPrice))){
                header("Location: Ad_posting_form.php?status=2");
                
            }else if(!($ad->validateDesc($description))){
                header("Location: Ad_posting_form.php?status=3");
                
            }else if(!($ad->validateDesc($title))){
                header("Location: Ad_posting_form.php?status=4");

            }else if(!($ad->validateNumbers($no_of_bedrooms))){
                header("Location: Ad_posting_form.php?status=5");

            }else if(!($ad->validateNumbers($no_of_bathrooms))){
                header("Location: Ad_posting_form.php?status=6");

            }else if(!($ad->validateNumbers($no_of_floors))){
                header("Location: Ad_posting_form.php?status=7");

            }else if(!($ad->validateArea($area))){
                header("Location: Ad_posting_form.php?status=8");

            }else if(!($ad->validateArea($floorArea))){
                header("Location: Ad_posting_form.php?status=9");

            }else if(!($ad->validateTelephone($contactNo))){
                header("Location: Ad_posting_form.php?status=10");

            }else if(validateImage('validDoc') === false){
                header("Location: Ad_posting_form.php?status=14");
            }else if(validateImage('img01') === false ||
                    validateImage('img02') === false ||
                    validateImage('img03') === false ||
                    validateImage('img04') === false ||
                    validateImage('img05') === false 
                    ){
                header("Location: Ad_posting_form.php?status=15");
            }
            
            else if($ad->postBidAdd()){
                header("Location: Ad_posting_form.php?status=11");
            }else{
                header("Location: Ad_posting_form.php?status=13");
            }
            
        }
    }else{
       $ad1 = new Advertisement($category,$type,$no_of_bedrooms,$no_of_bathrooms,$no_of_floors,$floorArea,$landArea,$title,$description,$price,$district,$town,$contactNo,$logitude,$lattitude,$image1,$image2,$image3,$image4,$image5);        //object of the Advertisement class
    
     if(!($ad1->validatePrice($price))){
        header("Location: Ad_posting_form.php?status=1");
        
    }elseif(!($ad1->validateDesc($description))){
        header("Location: Ad_posting_form.php?status=3");
        
    }elseif(!($ad1->validateDesc($title))){
        header("Location: Ad_posting_form.php?status=4");

    }elseif(!($ad1->validateNumbers($no_of_bedrooms))){
        header("Location: Ad_posting_form.php?status=5");

    }elseif(!($ad1->validateNumbers($no_of_bathrooms))){
        header("Location: Ad_posting_form.php?status=6");

    }elseif(!($ad1->validateNumbers($no_of_floors))){
        header("Location: Ad_posting_form.php?status=7");

    }elseif(!($ad1->validateArea($area))){
        header("Location: Ad_posting_form.php?status=8");

    }elseif(!($ad1->validateArea($floorArea))){
        header("Location: Ad_posting_form.php?status=9");

    }elseif(!($ad1->validateTelephone($contactNo))){
        header("Location: Ad_posting_form.php?status=10");

    }else if(validateImage('img01') === false ||
                    validateImage('img02') === false ||
                    validateImage('img03') === false ||
                    validateImage('img04') === false ||
                    validateImage('img05') === false 
                    ){
                header("Location: Ad_posting_form.php?status=15");
            }
    elseif($ad1->postAdd()){
        
        header("Location: Ad_posting_form.php?status=12");
    }else{
        header("Location: Ad_posting_form.php?status=13");
}
       
    }
}



?>

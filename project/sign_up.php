<?php

session_start();
//require_once  './classes/Email.php';
require_once './classes/User.php';
require_once './classes/Email.php';



// sending and matching opt codes
//sending otp when registering new 

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['register'])){
    // Validate and sanitize email address
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Generate OTP (4-digit random number)
    $myOtp = mt_rand(1000, 9999);
    $_SESSION['otp'] = $myOtp;
    
    $subject = "OTP for registration";
    $obj = new Mail;
    $obj->sendMail($email, $subject, $myOtp);
    echo "sent";
    
}

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
                header("Location: ./registration_form.php?status=12"); // Invalid file type
                exit;
            }
            
            $maxFile_Size = 5 * 1024 * 1024;    // (max is 5mb)
            if($file_size > $maxFile_Size){
                header("Location: ./registration_form.php?status=12"); // Invalid file type
                exit;
            }
            return file_get_contents($file_tmp);
        }
        
        return NULL;
        
    }

if(isset($_POST['register'])){
    /*
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
                header("Location: ./registration_form.php?status=12"); // Invalid file type
                exit;
            }
            
            $maxFile_Size = 5 * 1024 * 1024;    // (max is 5mb)
            if($file_size > $maxFile_Size){
                header("Location: ./registration_form.php?status=12"); // Invalid file type
                exit;
            }
            return file_get_contents($file_tmp);
        }
        
        return NULL;
        
    }
     * *
     */
    if(!empty($_POST['name']) && !empty($_POST['NIC']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmpassword']) && !empty($_POST['otpInput']) && !empty($_POST['contactNum']) && !empty($_POST['town']) && !empty($_POST['district']) && !empty($_POST['otpInput']) && !empty($_FILES['nicVerify'])){
        $username = strip_tags($_POST['name']);
        $nic = strip_tags($_POST['NIC']);
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $confirmpassword = strip_tags($_POST['confirmpassword']);
        $otpInput = strip_tags($_POST['otpInput']); 
        $contactnum = strip_tags($_POST['contactNum']);
        $address = strip_tags($_POST['address']);
        $town = strip_tags($_POST['town']);
        $district = strip_tags($_POST['district']);
        $myOtp = $_SESSION['otp'];
        $hashedPwd = password_hash($password, PASSWORD_BCRYPT);
        
        
        
        
         //uploading image
        // Validate and sanitize file upload
        
        
            $image = validateImage('nicVerify') !== false ? validateImage('nicVerify') : NULL;
        
         

        $signup = new User($username, $nic, $email, $password, $confirmpassword,$address,$town,$district,$contactnum,$otpInput,$myOtp,$image);

        if(!($signup->validateNic())){                               //validating contact number
            header("Location: ./registration_form.php?status=2");
        }
        else if(!($signup->validateTelephone())){                      //validating contact number
            header("Location: ./registration_form.php?status=3");
            //exit;
        }
        else if(!($signup->validateEmail())){                        //validating email
            header("Location: ./registration_form.php?status=4");
        }
        else if(!($signup->invalidEmail())){                         //check weather email is already is existing
            header("Location: ./registration_form.php?status=5");
        }
        else if(!($signup->validateUsername())){                     // validating username
            header("Location: ./registration_form.php?status=6");
        }
        else if(!($signup->validatePassword())){                    //validating password
            header("Location: ./registration_form.php?status=7");
        }
        else if(!($signup->passwordMatch())){                      //check weather password and confirm passsword are matching
            header("Location: ./registration_form.php?status=8");
        }
        else if(!($signup->otpMatch())){
            header("Location: ./registration_form.php?status=10");
        }
        else if(!($signup->checkRegistered_userList())){
            header("Location: ./registration_form.php?status=11");
        }else if(!($signup->checkPending_userTable())){
            header("Location: ./registration_form.php?status=14");
        }
        else if($signup->register($hashedPwd)){                              //submitting registration to the admin
            header("Location: ./registration_form.php?status=9");
        }
    }else{
        header("Location: ./registration_form.php?status=1");
    }
}


    
 
<?php
session_start();
include_once './classes/Registered_user.php';
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
        include './include/cookie_logger.php';
    }


?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,intial-scale=1.0">
        <title>Login</title>
        <style>
            /*----------------------------------------------------------------- login/sign_up ----------------------*/

*{
    margin :0;
    padding:0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;    
}

body{
    background-color:#F8F8FF;
}

.container{
    background:#fff;
    width:450px;
    padding:2rem;
    margin:50px auto; 
    border-radius:10px;
    box-shadow: 0 20px 35px rgba(0,0,1,0.5);
}



form {
    
   margin :0 2rem; 
   padding:1px;
}


.form_subtitle,.form_title,.dont-have{
    text-align:center;
}

.form_feild{
    padding: 5px;
   
}
.feild1{
     padding: 15px ;
     width: 300px;
     
}

.feild2{
    background-color:rgb(0,158,96);
    padding: 15px;
    color:#fff ;
    font-size: 15px;
    border-color:#fff;
    border-radius:10px; 
    width:45%;
    
}
.feild2:hover{
    background-color: #ebebeb;
    border:1px solid rgb(0,158,96);
    color:rgb(0,158,96);
}
.modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width:100%;
            height: 100%;
            overflow: auto; /* Enable scrolling if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 30%; /* Could be more or less, depending on screen size */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            top:0;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Responsive styles */
        @media screen and (max-width: 700px) {
            .modal-content {
                width: 90%;
            }
        }
        </style>
    </head>
    <body>
       

        <!--form start-->
        <div class="container" id="login">
        <div class="login-form">
             
            
            <form method="post" action="" autocomplete="off">
                <h4 class="form_title">Forgot Password</h4>
                
                <div class="form_feild">
                <input class="feild1" type="text" name="useremail" placeholder="Your Email*" required=""><br><br> 
                <input type="submit" name="send-opt" class="feild2" value="Send OTP">
                </div>
            </form>
            <form action="" method="POST">
                <div class="form_feild">
                <input class="feild1" type="password" name="otp"  placeholder="Enter OTP*" required=""><br><br>
                </div>
                <div class="form_feild">
                
                <input class="feild2" type="submit" name="forgotpassword" class="submit" value="Login">
                <input class="feild2" type="button" name="cancel" class="submit" value="Cancel" id="cancel">
                </div>
            </form>
        
        </div>
        </div>
        <!--form end-->
          <!-- Modal dialog for password reset -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            
            <h2 class="form_title">Reset Password<span class="close" onclick="closeModal()">&times;</span></h2><br>
            <form action="" method="post" id="resetForm">
                <input type="password" class="feild1" name="new_password" placeholder="New Password" required><br><br>
                <input type="password" class="feild1" name="confirm_password" placeholder="Confirm Password" required><br><br>
                <input type="submit" value="Save Changes" class="feild2" name="saveChanges">
            </form>
        </div>
    </div>

    
    <script>
        // Function to display modal
        function openModal() {
            document.getElementById('myModal').style.display = 'block';
        }

        // Function to close modal
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        // When the window clicks outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                closeModal();
            }
        }
    </script>

        <!--footer start-->
           
        <!--footer end-->
        <script>
           document.getElementById("cancel").addEventListener("click", function() {
           window.location.href = "index.php"; // Replace with your home page URL
        });

        </script>


       <?php
        
       if(isset($_POST['send-opt'])){
        $email = strip_tags($_POST['useremail']);

        $forgotPwd1 = new Registered_user();
        $forgotPwd1->setUseremail($email);
        $_SESSION['email'] = $email;
        if(!($forgotPwd1->validateEmail())){
            echo "<script>alert('Enter valid email')</script>";
           
        }
        else if(!($forgotPwd1->registeredEmail())){
            echo "<script>alert('Invalid Email')</script>";   //any user is not registered using this email
        }
        else{
            //$forgotPwd1->forgotPasswordOtp($email);
            // Generate OTP (4-digit random number)
        $otp = mt_rand(1000, 9999);
        //session_start();
        $_SESSION['otp']=$otp;
        $subject = "OTP for password recover";
        $obj = new Mail;
        $obj->sendMail($email, $subject, $otp);
        echo "<script>alert('OTP Sent')</script>";
        }


       }elseif(isset($_POST['forgotpassword'])){
           $forgotPwd2 = new Registered_user();
           $otpInput = $_POST['otp'];
           
           if($forgotPwd2->validateOtp($otpInput)){
            if($_SESSION['otp'] == $otpInput){
                echo "<script>openModal()</script>";
               }
               else{
                echo "<script>alert('OTP Wrong')</script>";
               }
           }
           else{
            echo "<script>alert('Please enter received OTP !')</script>";
           }
       }elseif(isset($_POST['saveChanges'])){
           $forgotPwd3 = new Registered_user;
           $forgotPwd3->setPassword($_POST['new_password']);
           $forgotPwd3->setConfirmPwd($_POST['confirm_password']);
           $forgotPwd3->setUseremail($_SESSION['email']);

           if(!($forgotPwd3->validatePassword())){
              echo "<script>alert('Enter valid password1')</script>";
           }elseif(!($forgotPwd3->validatePassword())){
               echo "<script>alert('Enter valid password2')</script>";
            }elseif(!($forgotPwd3->passwordMatch())){
                echo "<script>alert('passwords are not matching!')</script>";
           }else{
            $hashedPwd = password_hash($_POST['new_password'],PASSWORD_BCRYPT);
            $forgotPwd3->forgotPassword($hashedPwd);
           }
           
       }
?>
    </body>
</html>
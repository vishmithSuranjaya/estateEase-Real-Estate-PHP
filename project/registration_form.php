<?php
session_start();
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
        include './include/cookie_logger.php';
    }


?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,intial-scale=1.0">
        <title>sign_up</title>
        <link rel="icon" href="./images/logo.png" type="image/png">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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


.form_subtitle,.form_title,.have,.span_or{
    text-align:center;
}

.form_feild{
    padding: 5px;
   
}
.feild1{
     padding: 10px ;
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
.feild3{
  background-color: rgb(0,158,96);
  padding:10px;
  color:#fff;
  font-size: 10px;
  border-radius:10px;
}
.feild3:hover{
  background-color: #ebebeb;
  border:1px solid rgb(0,158,96);
  color:rgb(0,158,96);
}
.feild2:hover{
    background-color: #ebebeb;
    border:1px solid rgb(0,158,96);
    color:rgb(0,158,96);
}
#send-otp{
   padding: 5px;
   margin-bottom:5px;
}
        </style>
    </head>
    <body>
       
        <!--uppernavigation_bar start-->
           
        <!--uppernavigation_bar end-->
        
        <!--navigation_bar start-->
           
        <!--navigation_bar end-->
        
        <!--form start-->
        <div class="container" id="login">
        <div class="login-form">
             
            
            <form action="sign_up.php" method="POST" autocomplete="off" enctype="multipart/form-data">
            <!--error handling-->
            <?php 
            if (isset($_GET["status"])) {
              if ($_GET["status"] == 1) {
                echo "<script>alert('Please fill all fields!')</script>";
              } elseif ($_GET["status"] == 2) {
                echo "<script>alert('Please enter a valid NIC!')</script>";
              } elseif ($_GET["status"] == 3) {
                echo "<script>alert('Please enter a valid contact number!')</script>";
              } elseif ($_GET["status"] == 4) {
                echo "<script>alert('Please enter a valid email!')</script>";
              } elseif ($_GET["status"] == 5) {
                echo "<script>alert('Email has alerady taken!')</script>";
              } elseif ($_GET["status"] == 6) {
                echo "<script>alert('Please enter a valid user name')</script>";
              } elseif ($_GET["status"] == 7) {
                echo "<script>alert('Please enter a valid password!')</script>";
              } elseif ($_GET["status"] == 8) {
                echo "<script>alert('Passwords does not match!')</script>";
              }else if($_GET['status'] == 10){
                echo "<script>alert('Otp does not match')</script>";
              }else if($_GET['status'] == 11){
                echo "<script>alert('this NIC is already in the system')</script>";
              }else if($_GET['status'] == 12){
                echo "<script>alert('Invalid image file type !!')</script>";
              }else if($_GET['status'] == 13){
                echo "<script>alert('NIC image upload error!!')</script>";
              }else if($_GET['status'] == 14){
                echo "<script>alert('You have already Requested to Sign Up!')</script>";
              }
               elseif ($_GET["status"] == 9) {
                echo '<script>alert("Registration submitted to admin approval!");window.location="index.php";</script>';
              }
              
            } 
            ?>
                <h1 class="form_title">Register</h1>
                <p class="form_subtitle">Access to our dashboard</p>
               <div class="form_feild">
                 <input class="feild1" type="text" name="name" placeholder="Name*" ><br><br>
               </div>
               <div class="form_feild">   
                 <input class="feild1" type="text" name="NIC" placeholder="NIC*" required=""><br><br>
               </div>
                <div class="form_feild">
                 <input class="feild1" type="email" name="email" id="email" placeholder="Email*" required=""><br><br>
               </div>
                <div class="form_feild">
                 <input class="feild1" type="password" name="password" placeholder="Password*" required="" ><br><br>
               </div>
               <div class="form_feild">
                 <input class="feild1" type="password" name="confirmpassword" placeholder="Confrim Password*" required=""><br><br>
               </div>
                <div class="form_feild">
                  <button type="button" onclick="sendOTP()" class="feild3">SEND OTP</button>
                 <input class="feild1" type="text" name="otpInput" placeholder="OTP code*"><br><br>
               </div>
               <div class="form_feild">
                 <input class="feild1" type="text" name="contactNum" placeholder="Contact Number*" required=""><br><br>
               </div>
               <div class="form_feild">
                 <input class="feild1" type="text" name="address" placeholder="address*" required><br><br>
               </div>
               <div class="form_feild">
                   <label for="">Upload clear image of your NIC</label><br>
                   <input type="file" name="nicVerify"  required class="form-control"><br>
                   <p style="color:green; font-size:13px;">*Required image size is 5MB</p><br>
               </div>
               <div class="form_feild">   
                 <!--<input class="feild1" type="text" name="district" placeholder="District*" required=""><br><br>-->
                 <label for="district">District:</label><br>
                 <select class="form-control"  id="dropdown1" name="district" onchange="updateTowns()">
                        <option value="colombo">Colombo</option>
                        <option value="gampaha">Gampaha</option>
                        <option>Kalutara</option>
                        <option>Kegalle</option>
                        <option>Ratnapura</option>
                        <option>Badulla</option>
                        <option>Monaragala</option>
                        <option>Galle</option>
                        <option>Hambantota</option>
                        <option>Matara</option>
                        <option>Kurunegala</option>
                        <option>Puttalam</option>
                        <option>Anuradhapura</option>
                        <option>Polonnaruwa</option>
                        <option>Kandy</option>
                        <option>Matale</option>
                        <option>Nuwara Eliya</option>
                        <option>Ampara</option>
                        <option>Batticaloa</option>
                        <option>Trincomalee</option>
                        <option>Jaffna</option>
                        <option>Kilinochchi</option>
                        <option>Mannar</option>
                        <option>Vavuniya</option>
                        <option>Mullaitivu</option>
                    </select>
               </div>
               <div class="form_feild">   
                <!-- <input class="feild1" type="text" name="town" placeholder="Town*" required=""><br><br>-->
                 <label for="town">Town:</label>
                    <select class="form-control" name="town" id="a">
                       
                    </select>
               </div>
               <div class="form_feild">   
                  <input class="feild2" type="submit" name="register" id="" value="Sign Up">
                  <input class="feild2" type="button" name="cancel" id="cancel" value="Cancel">
               </div>
       
             <div class="have">Already have an account?<a href="login.php"> Login</a></div>
        
           </form>
        </div>
        </div>
        
        <script>
          //when press cancel directed to home page
          document.getElementById("cancel").addEventListener("click", function() {
          window.location.href = "index.php"; // Replace with your home page URL
        });


        //getting user email and send email to send_otp.php file
        
        function sendOTP() {
            var otpemail = document.getElementById('email').value;
            if (otpemail.trim() === '') {
                alert('Please enter your email address.');
                return;
            }else if(!(emailValidateforOtp(otpemail))){
                alert('Enter valid email address!');
                return;
            }
            
            // Send AJAX request to send OTP via email to the 'sign_up.php' file
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'sign_up.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                } else {
                    alert('Request failed. Please try again later.');
                }
            };
            xhr.send('email=' + otpemail);
        }
           // javascript regex function for check email when send otp button is pressed
        function emailValidateforOtp(otpemail) {
            const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
            return emailRegex.test(otpemail);
        }


        //update dynamically town dropdown list according to district list value
        function updateTowns() {
            var district = document.getElementById("dropdown1").value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './townlist_update.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("a").innerHTML = xhr.responseText;
                }
            };
            
            xhr.send("district=" + encodeURIComponent(district));
        }
        </script>
    </body>
</html>

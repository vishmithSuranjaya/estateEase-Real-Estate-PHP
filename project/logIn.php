<?php
//starts the session in the page
session_start();
//if the session is set, then should redirect the the index.php
if (isset($_SESSION['status'])) {
    header("Location: index.php");
    exit();
}

//included necassary php files.
require_once './classes/Registered_user.php';
require_once './classes/Admin.php';

/// login
//checking if there are cookies or if the login submit button is clicked in the form
if (isset($_POST['login']) || isset($_COOKIE['useremail'])) {

    $useremail = strip_tags($_POST['useremail']);
    $password = strip_tags($_POST['password']);

    if (isset($_COOKIE['useremail']) && isset($_COOKIE['password'])) {
        //cookies are set from here
        $useremail = $_COOKIE['useremail'];
        $password = $_COOKIE['password'];
    }

    $login = new Registered_user();  //new registered user object is created
    $login->setPassword($password);
    $login->setUseremail($useremail);
    $result = $login->Login(); //logging the user in

    if ($result == 1) {
        $_SESSION['login'] = true;
        $_SESSION["id"] = $login->idUser(); //getting user NIC from the resultset
        $_SESSION['username'] = $login->userName(); //getting username from resultset
        $_SESSION['useremail'] = $login->userEmail();
        $_SESSION['role'] = $login->getRole();

        // Check if "Remember Me" was selected
        if (isset($_POST['remember'])) {
            echo "<script>alert(1);</script>";
            // Set cookies for 1 days (86400 seconds)

            setcookie('useremail', $useremail, time() + (86400), "/");
            setcookie('password', $password, time() + (86400), "/");
        }

        if ($_SESSION['role'] == "customer") {
            $_SESSION['status'] = 1;
            header("Location: index.php");
            exit();
        } else {
            $login->logout(); //logs out the registered user object
            session_start();  //since session is destroyed, start a new session for the admin
            $admin = new Admin($useremail);  //new admin object is created
            $_SESSION['id'] = $admin->idUser();  // assigning session variables
            $_SESSION['useremail'] = $admin->userEmail();
            $_SESSION['username'] = $admin->userName();
            $_SESSION['role'] = $admin->getRole();
            $_SESSION['status'] = 1;
            //redirecting to the admin panel
            header("Location: ./Admin_Dashboard/admin_panel.php");
            exit();
        }
    } elseif ($result == 10) {
        echo "<script> alert('Email or Password is wrong'); </script>";
    } elseif ($result == 100) {
        echo "<script> alert('User Not Registered'); </script>";
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,intial-scale=1.0">

        <link rel="icon" href="./images/logo.png" type="image/png">
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
        </style>
    </head>
    <body>


        <!--form start-->
        <div class="container" id="login">
            <div class="login-form">


                <form method="post" action="">
                    <h1 class="form_title">Login</h1>
                    <p class="form_subtitle">Access to your account</p>
                    <div class="form_feild">
                        <input class="feild1" type="text" name="useremail" placeholder="Your Email*" required=""  value="<?php if (isset($_COOKIE['useremail'])) {
    echo $useremail;
} ?>"><br><br> 
                    </div>
                    <div class="form_feild">
                        <input class="feild1" type="password" name="password"  placeholder="Your Password*" required="" value="<?php if (isset($_COOKIE['password'])) {
    echo $password;
} ?>"><br><br>
                    </div>
                    <div class="form_feild">
                        <input type="checkbox" name="remember" value="rmbme">&nbsp;&nbsp;&nbsp;&nbsp;Remember me<br><br>
                        <input class="feild2" type="submit" name="login" class="submit" value="Login">
                        <input class="feild2" type="button" name="cancel" class="submit" value="Cancel" id="cancel">
                    </div>
                </form>



                <div class="dont-have">Don't have an account? <a href="registration_form.php">Register</a></div>
                <div class="dont-have"><a href="forgot_password.php">Forgot password?</a></div>
            </div>
        </div>
        <!--form end-->


        <!--footer start-->

        <!--footer end-->
        <script>
            document.getElementById("cancel").addEventListener("click", function () {
                window.location.href = "index.php"; // Replace with your home page URL
            });

        </script>
        <script src="./script.js"></script>
    </body>
</html>

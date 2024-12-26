<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
/*-------------------------------------------------------------------------- footer ----------------------*/
:root {
    --main-color: rgb(0, 158, 96);
    --first-color: #ebebeb;
    --second-color: #099d02;
    --third-color: #fff;
    --font-color: black;
    --hover-color: #099d02;
}

.footer{
    background-color: var(--first-color);
    margin-top: 0;
    min-height: 50vh;
    color: var(--font-color);
}

.footer .footer-title h1{
    text-align: center;
    padding-top: 1rem;
    padding-bottom: 1rem;
    color: var(--font-color);
}
.footer .footer-links{
    text-align: center;
    font-size: 1.5rem;
    padding-bottom: 2rem;
}
.footer .footer-links a{
    position: relative;
    padding: 2rem;
    text-decoration: none;
    color: var(--font-color);
}
.footer .footer-links a::after{
    position: absolute;
    content: "";
    width: 80%;
    background: var(--main-color);
    height: 3px;
    bottom: 30px;
    left: 27px;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s;
}
.footer .footer-links a:hover::after{
    transform-origin: left;
    transform: scaleX(1);
}
.footer .footer-desc{
    text-align: center;
}
.footer .footer-social-links{
    text-align: center;
}
.footer .footer-social-links i{
    font-size: 30px;
    padding: 1rem;
    color: var(--font-color);
}
.footer .footer-social-links i:hover{
    color: var(--second-color);
}
.footer .footer-cal {
    padding: 2rem;
    position: relative; 
}
  
.footer .footer-cal .fc-center {
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
.footer .footer-cal .fc-center button{
    padding: 10px;
    background-color: var(--first-color);
    color: var(--second-color);
    border: 1px solid var(--second-color);
    border-radius:7px;
}
.footer .footer-cal .fc-center button:hover{
    background-color: var(--hover-color);
    color: var(--first-color);
    border: 1px solid var(--first-color);
}
/*-------------------------------------------------------------- scroll button --------------*/
#scrollTopBtn{
    display:none;
    position: fixed;
    bottom: 20px;
    right: 30px;
    z-index: 99;
    font-size: 18px;
    border: none;
    background-color: var(--main-color);
    cursor: pointer;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    border: 1px solid var(--font-color);
}
#scrollTopBtn:hover{
    background-color: var(--first-color);
    border: 1px solid var(--main-color);
    color: var(--main-color);
}
#scrollTopBtn:hover>i{
    color: var(--font-color);
}
#scrollTopBtn i{
    font-size: 1.5rem;
    color: var(--font-color);
    align-items: center;
}


    </style>
</head>
<body>
    
<!------------------------------------------------------------------------- footer ---------------------------->
<section class="footer">

<div class="footer-title">
    <h1>estateEase</h1>
    <hr>
</div>

<div class="footer-links">
    <a href="./aboutUs.php">About US</a>
    <a href="./search_filter.php">Properties</a>
    <a href="./logIn.php">Sign In</a>
    <a href="./terms_conditions.php">Terms & Conditions</a>
</div>

<div class="footer-desc">
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque ratione, reiciendis nisi minus quisquam tempore iste minima at possimus <br>
     quo vel, sit architecto? Consectetur quos eligendi optio natus minus exercitationem quis quo, delectus, est <br>sapiente ea adipisci, sit maxime dolores nulla itaque nobis repellat voluptate! Aliquid consectetur dicta corporis ut?</p>
</div>

<div class="footer-cal">
    <div class="fc-center">
        <a href="./search_filter.php"><button>INSTALMENT CALCULATOR</button></a>
    </div>
</div>

<div class="footer-social-links">
    <a href=""><i class="bi bi-facebook"></i></a>
    <a href=""><i class="bi bi-facebook"></i></a>
    <a href=""><i class="bi bi-instagram"></i></a>
</div>
</section>


</body>
</html>
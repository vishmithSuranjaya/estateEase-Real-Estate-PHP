<?php
if(isset($_SESSION['status'])){
    if($_SESSION['role'] == "admin") {
        header("Location: ./Admin_Dashboard/admin_panel.php");
        exit();
    }
}

//require_once './classes/Registered_user.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>estateEase</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <!-------google fonts -------------->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />

    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Css stylesheet-->
    <style>
:root {
    --main-color: rgb(0, 158, 96);
    --first-color: #ebebeb;
    --second-color: #099d02;
    --third-color: #fff;
    --font-color: black;
    --hover-color: #099d02;
    --background-color: #fff;
    --btn-color: #099d02;
}
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}
/*------------------------------------------------Upper-nav-----------------*/

.upper_nav{
    display: grid;
    grid-template-columns: 35% 45% 20%;
    margin: 0rem;
    padding: 1rem;
    background-color: var(--first-color);
}
.upper_nav .logo{
    left: 0;
}

.upper_nav .search-input{
   // place-items: center;
   padding-top:12px;
}
.upper_nav .search-input input{
    border-radius: 30px;
    width: 70%;
    border: var(--first-color);
    background-color: rgb(231, 225, 225);
    padding: 5px;
    padding-left: 20px;
}
.upper_nav .search-input #search-button{
    border: var(--font-color);
    padding: 2px;
    background-color: var(--first-color);
    color: var(--font-color);
}
.upper_nav .search-input #search-button:hover{
    color: var(--second-color);
}
.upper_nav .icons button{
    background: none;
    border: none;
    padding: 0;
    margin: 0;
}
.upper_nav .icons #darkTheme{
    display: none;
}
.upper_nav .icons i{
    float: right;
    padding-right: 0.5rem;
    font-size: 1.5rem;
    color: var(--font-color);
}

/*----------------------------------------------- navbar stlying ---------------------*/
.navbar{
    background-color: var(--main-color);
    display: flex;
    justify-content: space-between;
    padding: 0.6rem;
}
.navbar a{
    position: relative;
    padding-top: 10px;
    color: #fff;
    text-decoration: none;
    padding-left: 2rem;
}
.navbar a:hover{
    color: #fff;
}
.navbar .nav-link::after{
    content: "";
    position: absolute;
    left: 1.8rem;
    bottom: 4px;
    width: 55%;
    height: 2px;
    background: #fff;
    border-radius: 40px;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s;
}
.navbar .nav-link:hover::after{
    transform-origin: left;
    transform: scaleX(1);
}
.navbar .navbar-btn1{
    background-color: var(--first-color);
    padding: 10px;
    color: var(--second-color);
    border: 1px solid var(--second-color);
    border-radius:10px;
}
.navbar .navbar-btn2{
    text-align: center;
    background-color: var(--first-color);
    padding-top: 2px;
    padding: 5px;
    color: var(--second-color);
    border: 1px solid var(--second-color);
    margin-left: 2rem;
    border-radius:10px;
}
.navbar .navbar-btn1:hover{
    background-color: var(--hover-color);
    border: 1px solid var(--first-color);
    color: var(--first-color);
}
.navbar .navbar-btn2:hover{
    background-color: var(--hover-color);
    border: 1px solid var(--first-color);
    color: var(--first-color); 
}
.dropdown-icons button,i{
    background: none;
    border:none;
    padding-right:4px;
}
/*----------------------------------------------------------- media queries-------------------------------*/
@media screen and (max-width: 680px) {
   .navbar .nav{
    display: none; 
   }
   .navbar .navbar-navbar-dark-bg-dark-fixed-top{
    display: block;
   }
   .search-input{
    display:none;
   }
   .icons{
    display:grid;
    grid-template-columns: 60% 40%;
   }
   .upper_nav{
    display:block;
   }
   
}
@media screen and (min-width:680px){
    .navbar .navbar-navbar-dark-bg-dark-fixed-top{
        display: none;
    }
    

}

    </style>

</head>
<body>

<!---------------------------------------- Upper navbar section --------------------------->
    <section class="upper_nav">
        
        <div class="logo">
            <a href="./index.php"><img src="./images/WhatsApp_Image_2024-06-12_at_11.55.18_AM-removebg-preview.png" alt="logo comes here..!"></a>
        </div>

        <div class="search-input">
            <form action="search_filter.php" method="POST">
            <input type="search" name="search" id="search-input" placeholder="search here....">
            <button id="search-button" type='submit' name='submit'>
            <i class="bi bi-search"></i><!--search icon-->
            </button>
            </form>
        </div>

        <div class="icons">
        
        <button id="lightTheme" onclick="lightThemeon()"><i class="bi bi-sun"></i><!--light theme sun icon--></button>
        <button id="darkTheme" onclick="darkThemeon()"><i class="bi bi-moon-fill"></i><!--dark theme moon--></button>
        <?php if( isset($_SESSION['id']) && !empty($_SESSION['id']) ){?>
        <a href = "wishlist.php"><button><i class="bi bi-heart"></i><!--wish list icon--></button></a>
           <button onClick="document.location.href='./user_dashboard.php'"><i class="bi bi-person-fill"></i><!--account icon--></button>
           <p style="color: var(--font-color);float:right;"><?php
               if(isset($_SESSION['status'])){
                echo $_SESSION['username'];
            }
            
            ?>
            </p>
        <?php }
        else{ ?>
            
        <?php } ?>
        
        
    </div>
    
    </section>

<!-------------------------------------------------------------navbar section -----------navbar-btn1------------>
   <section class="navbar">
        <div class="post">
            <a href="Ad_posting_form.php" class="navbar-btn1">Post An Add</a>
        </div>

        <div class="nav">
            <a href="./index.php" class="nav-link">Home</a>
            <a href="./search_filter.php" class="nav-link">Filter Ads</a>
            
            
            
           <!-- <a href="" class="navbar-btn2">log In</a>
            <a href="" class="navbar-btn2">Sign In</a>-->
            <?php if( isset($_SESSION['id']) && !empty($_SESSION['id']) ){?>
                <a href="logout.php" class="navbar-btn2">Logout</a>
            
            <?php }
            else{ ?>
                <a href="./login.php" class="navbar-btn2">Login</a>
                <a href="./registration_form.php" class="navbar-btn2">Register</a>
            <?php } ?>
        </div>

        <nav class="navbar-navbar-dark-bg-dark-fixed-top">
  <div class="container-fluid">
    
    
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Log In</a>
          </li>
          <li>
            
          </li>
          <li class="nav-item dropdown">
            
            <ul class="dropdown-menu dropdown-menu-dark">
              
              <li>
                
              </li>
              
            </ul>
            <li>
          <div class="dropdown-icons">
        
        <button id="lightTheme" onclick="lightThemeon()"><i class="bi bi-sun"></i><!--light theme sun icon--></button>
        <button id="darkTheme" onclick="darkThemeon()"><i class="bi bi-moon-fill"></i><!--dark theme moon--></button>
        <?php if( isset($_SESSION['id']) && !empty($_SESSION['id']) ){?>
           <button><i class="bi bi-heart"></i><!--wish list icon--></button>
           <button onClick="document.location.href='./user_dashboard.php'"><i class="bi bi-person-fill"></i><!--account icon--></button>
           <?php
               if(isset($_SESSION['status'])){
                echo $_SESSION['username'];
            }
            ?>
        <?php }
        else{ ?>
            
        <?php } ?>
        
        
    </div>
          </li>
          </li>
          
        </ul>
        <form action="search_filter.php" method="POST">
            <input type="search" name="search" id="search-input" placeholder="search here....">
            <button id="search-button" type='submit' name='submit'>
            <i class="bi bi-search"></i><!--search icon-->
            </button>
            </form>
      </div>
    </div>
  </div>
</nav>
   </section>

   <script src="./script.js"></script>
</body>
</html>
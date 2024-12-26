<?php
//start the session from here
session_start();
//this logs in the user if the browser was closed in the mid of a session without logging out
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
        include './include/cookie_logger.php';
    }
//redirects the page to the advance payment page when paying the advance fees 
if(isset($_COOKIE['bidPayment'])){
    $advertisement_id = $_COOKIE['bidPayment'];
    setcookie('bidPayment','', time() - 3600, "/");
    header("Location: bidPayment.php?p=".$advertisement_id);
    exit();
}
//included necassary php files
include_once './classes/dbConnector.php';
include_once "./include/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
     <!-------google fonts -------------->
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <!-- swiper.js CSS -->
    
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    
    <link rel="styleSheet" type="text/css" href="./CSS/styles.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <!-- <script src="script.js"></script> -->
    <style>
        .swiper-caption {
            position: absolute;
            bottom: 20px;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.0);
            padding: 10px;
            text-align: center;
        }
        .swiper-slide {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
         /* styles for the map. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 100%;
            width:94%;
            margin:auto;
            background-color: var(--background-color) !important;
            
        }
        #form table tr td{
            padding: 10px;
        }
    </style>
    
    <!---------------------------------for map----------------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
</head>
<body>
    <!-------------------------------------------------------- Banner section -------------------------->
 <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="./images/2107211707001.jpg" alt="First slide" class="d-block w-100">
                <div class="swiper-caption">
                    <h5>Invest in Your Future, Today</h5>
                    <p>Secure a property that will grow in value and enhance your life..!</p>
                </div>
            </div>
            <div class="swiper-slide">
                <img src="./images/2107211707192.jpg" alt="Second slide" class="d-block w-100">
                <div class="swiper-caption">
                    <h5>Comfort, Style, and Convenience Combined..!</h5>
                    <p>Homes that offer luxury, practicality, and proximity to everything you need.</p>
                </div>
            </div>
            <div class="swiper-slide">
                <img src="./images/2107211707363.jpg" alt="Third slide" class="d-block w-100">
                <div class="swiper-caption">
                    <h5>Bid for the best Deal</h5>
                    <p>Showcase the competitve Bidding Feature, where users can place offers on Properties..!</p>
                </div>
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.mySwiper', {
            loop: true,
            spaceBetween: 0,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
    
    
    
    <section class="advertiments">
  <h4>Properties for Sale</h4>
<div class="sellAds">
  
  <?php
        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        $query = "SELECT a.*, i.image1 as image
                    FROM advertisement a 
                    LEFT JOIN images i ON a.ad_id = i.ad_id
                    WHERE a.category != ? AND a.category != 'hidden'
                    ORDER BY RAND()
                    LIMIT 8";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, "Rent");
            $pstmt->execute();
            
          if($pstmt->rowCount()>0){
          while($rs = $pstmt->fetch(PDO::FETCH_ASSOC)){
          echo 
    " <section class='content'>
        <div class='box'>
        <div class='card' style='width: 18rem;'>";
          
            if(!empty($rs['image'])){
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->buffer($rs['image']);
                    echo "<div class='card-img-container'>
                    <img src='data:".$mimeType.";base64,".base64_encode($rs['image'])."' alt='Property Image' class='doc'>
                            </div>";
                } else {
                    echo "
                    <p class='card-img-top'>No image Available</p>
                    ";
                }
          echo "      
          <div class='card-body'>
            <p class='card-text'>". $rs['title']. "</p>
            <p >". $rs['description']. "</p>
            <p>Price: ". $rs['price']. "</p>
            <p>Type: ". $rs['type']."   |   Category: ".$rs['category']."</p>
            <table class='ad-box'>
               <tr>";
                    if (!empty($rs['land_Area'])) {
                        echo "<td>AREA<br>" . $rs['land_Area'] . "</td>";
                    }
                    if (!empty($rs['no_of_bedrooms'])) {
                        echo "<td>BEDS<br>" . $rs['no_of_bedrooms'] . "</td>";
                    }
                    if (!empty($rs['no_of_bathrooms'])) {
                        echo "<td>BATH<br>" . $rs['no_of_bathrooms'] . "</td>";
                    }
                    if (!empty($rs['no_of_floors'])) {
                        echo "<td>FLOORS<br>" . $rs['no_of_floors'] . "</td>";
                    }
                    if (!empty($rs['floor_area'])) {
                        echo "<td>FLOOR AREA<br>" . $rs['floor_area'] . "</td>";
                    }
                    
            echo "        
               </tr>
            </table>
                <div class='button_group'> 
                    <a href='ad_redirector.php?ad_id=".$rs['ad_id']."' class='btn' name='gotoDetails'>Details</a>";

                  if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                        $ad_id = $rs['ad_id'];
                        $nic = $_SESSION['id'];

                        $sql9 = 'SELECT EXISTS (SELECT 1 FROM wishlist WHERE ad_id = :ad_id AND nic = :nic) AS record_exists;';
                        $stmt10 = $con->prepare($sql9);
                        $stmt10->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
                        $stmt10->bindValue(':nic', $nic, PDO::PARAM_STR);
                        $stmt10->execute();
                        $result = $stmt10->fetch(PDO::FETCH_ASSOC);

                        $heartType = $result['record_exists'] ? 'bi bi-heart-fill' : 'bi bi-heart';

                        echo "
                            <button type='submit' class='btn2' name='wishList' onclick='saveToWishlist(" . $ad_id . ",\"" . $nic . "\", this)'><i class='" . $heartType . "'></i></button>";
                    }


                    echo "
                </div>

           </div>
        </div>
        </div>
      </section>";
 }
}
}catch(PDOException $e){
  die("Connection failed".$e->getMessage());
}
  
  ?>

</div>
</section>


<!--------------------------rent advertisements --------------------------------------->

<section class="advertiments">
  <h4>Properties for Rent</h4>
<div class="sellAds">
  
  <?php
        $dbcon = new dbConnector;
        $con = $dbcon->getConnection();
        $query = "SELECT a.*, i.image1 as image
                    FROM advertisement a 
                    LEFT JOIN images i ON a.ad_id = i.ad_id
                    WHERE a.category = ?
                    ORDER BY RAND()
                    LIMIT 8";
        try {
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, "Rent");
            $pstmt->execute();
            
          if($pstmt->rowCount()>0){
          while($rs = $pstmt->fetch(PDO::FETCH_ASSOC)){
          echo 
    " <section class='content'>
        <div class='box'>
        <div class='card' style='width: 18rem;'>";
            if(!empty($rs['image'])){
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->buffer($rs['image']);
                    echo "<div class='card-img-container'>
                    <img src='data:".$mimeType.";base64,".base64_encode($rs['image'])."' alt='Property Image' class='doc'>
                            </div>";
                } else {
                    echo "
                    <p class='card-img-top'>No image Available</p>
                    ";
                }
          echo " 
          <div class='card-body'>
            <p class='card-text'>". $rs['title']. "</p>
            <p >". $rs['description']. "</p>
            <p>Price: ". $rs['price']. "</p>
            <p>Type: ". $rs['type']."   |   Category: ".$rs['category']."</p>
            <table class='ad-box'>
               <tr>";
                    if (!empty($rs['land_Area'])) {
                        echo "<td>AREA<br>" . $rs['land_Area'] . "</td>";
                    }
                    if (!empty($rs['no_of_bedrooms'])) {
                        echo "<td>BEDS<br>" . $rs['no_of_bedrooms'] . "</td>";
                    }
                    if (!empty($rs['no_of_bathrooms'])) {
                        echo "<td>BATH<br>" . $rs['no_of_bathrooms'] . "</td>";
                    }
                    if (!empty($rs['no_of_floors'])) {
                        echo "<td>FLOORS<br>" . $rs['no_of_floors'] . "</td>";
                    }
                    if (!empty($rs['floor_area'])) {
                        echo "<td>FLOOR AREA<br>" . $rs['floor_area'] . "</td>";
                    }
                    
            echo "        
               </tr>
            </table>
                <div class='button_group'> 
                    <a href='ad_redirector.php?ad_id=".$rs['ad_id']."' class='btn' name='gotoDetails'>Details</a>";
                    
                  if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                        $ad_id = $rs['ad_id'];
                        $nic = $_SESSION['id'];

                        $sql9 = 'SELECT EXISTS (SELECT 1 FROM wishlist WHERE ad_id = :ad_id AND nic = :nic) AS record_exists;';
                        $stmt10 = $con->prepare($sql9);
                        $stmt10->bindValue(':ad_id', $ad_id, PDO::PARAM_INT);
                        $stmt10->bindValue(':nic', $nic, PDO::PARAM_STR);
                        $stmt10->execute();
                        $result = $stmt10->fetch(PDO::FETCH_ASSOC);

                        $heartType = $result['record_exists'] ? 'bi bi-heart-fill' : 'bi bi-heart';

                        echo "
                            <button type='submit' class='btn2' name='wishList' onclick='saveToWishlist(" . $ad_id . ",\"" . $nic . "\", this)'><i class='" . $heartType . "'></i></button>";
                    }


                    echo "
                </div>

           </div>
        </div> 
        </div>
      </section>";
 }
}
}catch(PDOException $e){
  die("Connection failed".$e->getMessage());
}
  
  ?>

</div>
</section>
<?php
  include './addMaptoIndex.php';
  include_once './include/footer.php';
?>

<script src='./script.js'></script>
</body>
</html>
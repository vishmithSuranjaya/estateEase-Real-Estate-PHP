<?php 

if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
    include './include/cookie_logger.php';
}

require_once './classes/bidAds.php';
if(isset($_GET["s"])){
    $Ad_ID = $_GET["s"];
    setcookie('bidPayment',$Ad_ID, time() + (300), "/");
    $_SESSION['bid_ad_id'] = $Ad_ID;
}else if(isset($_GET["p"])){
    $Ad_ID = $_GET["p"];
    setcookie('bidPayment_1',$Ad_ID, time() + (300), "/");
    $_SESSION['bid_ad_id'] = $Ad_ID;
}
else{
    $Ad_ID=0;
}


if($_SESSION['status'] != 1){
    header("Location: login.php");
    exit();
}  

$bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);

if($bid->checkPaymentsTable($Ad_ID)){
    header("Location: alreadyPaid.php?s=".$Ad_ID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Payment</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <link rel="stylesheet" href="./css/ViewBidstyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        .bigDiv, strong, .table td{
            color:var(--font-color);
        }
    </style>

</head>
<body>
    <!--header-->
    <?php include './include/header.php'; 
    
    // DB connection and query to get advertisement details
    require_once './classes/dbConnector.php'; 
    require_once './classes/BidAds.php';

        $bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);
        $adbid = $bid->getAdDetails($Ad_ID);
    ?>
    
    <div class="container mt-4 bigDiv">
        <div class="row">
            <!-- Advertisement details (left side) -->
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($adbid['title']); ?></h2>
                <hr>
                <table class="table table-bordered">
                    <tr><td><strong>Type:</strong></td><td><?php echo htmlspecialchars($adbid['type']); ?></td></tr>
                    <tr><td><strong>Description:</strong></td><td><?php echo htmlspecialchars($adbid['description']); ?></td></tr>
                    <tr><td><strong>District:</strong></td><td><?php echo htmlspecialchars($adbid['district']); ?></td></tr>
                    <tr><td><strong>Town:</strong></td><td><?php echo htmlspecialchars($adbid['town']); ?></td></tr>
                    <tr><td><strong>Highest Bid (Your Bid): </strong></td><td>Rs <?php echo htmlspecialchars($adbid['price']); ?></td></tr>
                </table>

                <!-- Image Display -->
                <div class="swiper mySwiper">
                 <div class="swiper-wrapper">
                     <?php 
                          if(!empty($adbid['image1'])){?>
                    <div class="swiper-slide">
                        <?php 
                          if(!empty($adbid['image1'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adbid['image1']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adbid['image1']); ?>" alt='Image1' class="doc">
                              <?php

                          } else {
                              ?>
                              <p>No image1 Available</p>
                              <?php
                          }
                          ?>
                    </div>
                     <?php } ?>
                     
                     <?php 
                          if(!empty($adbid['image2'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adbid['image2'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adbid['image2']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adbid['image2']); ?>" alt='Image2' class="doc">
                              <?php

                          } else {
                              ?>
                              <p>No image2 Available</p>
                              <?php
                          }
                          ?>
                      </div>
                     <?php } ?>
                     <?php 
                          if(!empty($adbid['image3'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adbid['image3'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adbid['image3']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adbid['image3']); ?>" alt='Image3' class="doc">
                              <?php

                          } else {
                              ?>
                              <p>No image3 Available</p>
                              <?php
                          }
                          ?>
                      </div>
                     <?php } ?>
                     <?php 
                          if(!empty($adbid['image4'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adbid['image4'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adbid['image4']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adbid['image4']); ?>" alt='Image4' class="doc">
                              <?php

                          } else {
                              ?>
                              <p>No image4 Available</p>
                              <?php
                          }
                          ?>
                      </div>
                     <?php } ?>
                     <?php 
                          if(!empty($adbid['image5'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adbid['image5'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adbid['image5']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adbid['image5']); ?>" alt='Image5' class="doc">
                              <?php

                          } else {
                              ?>
                              <p>No image5 Available</p>
                              <?php
                          }
                          ?>
                      </div>
                          <?php } ?>
                        
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>

            </div>
            </div>

            <!-- Payment Section (right side) -->
            <div class="col-md-4">
                <h3>Complete Property Reserving Payment</h3>
                <hr>
                <h1 style="color:green">Rs 20,000/=</h1>
                <div class="alert alert-info">
                    <ul>
                        <li>Please understand these funds are non-refundable.</li>
                        <li>Paying this Advance Payment will reserve the property until a valid property transaction is made.</li>
                        <li>proceed to payment to finalize your purchase.</li>

                    </ul>
                                    </div>
                <hr>
                
                <div class="d-grid">
                    <button class="btn btn-success" id="pay-now" onclick="bidPayment()">Pay Here</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include './include/footer.php'; ?>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
            <script>
                console.log('Initializing Swiper');
                var swiper = new Swiper('.mySwiper', {
                    loop: true,
                    spaceBetween: 0,
                    centeredSlides: true,
                    autoplay: {
                        delay: 1300,
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
    <script type="text/javascript" src="http://www.payhere.lk/lib/payhere.js"></script>
</body>
</html>

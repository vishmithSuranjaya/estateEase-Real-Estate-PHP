<?php
//session_start();
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
        include_once './include/cookie_logger.php';
    }


require_once './classes/BidAds.php';    
    
if(isset($_GET['ad_id'])){
    $ad_id = $_GET['ad_id'];
}
if(isset($_SESSION['status'])){
    $nic = $_SESSION['id'];
$email = $_SESSION['useremail'];
}

try {
    $bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);
    if($bid->checkAdTable($ad_id)){
        header("Location: bidOver.php?s=".$ad_id);
        exit();
    }
} catch (Exception $ex) {
    die("Error!".$ex->getMessage());
}

//include_once './classes/dbConnector.php';
$dbcon = new DbConnector();
$con = $dbcon->getConnection();

try {
    $sql9 = 'SELECT EXISTS (SELECT 1 FROM bids WHERE ad_id = :Ad_ID) AS record_exists;';
    $stmt7 = $con->prepare($sql9);
    $stmt7->bindParam(':Ad_ID', $ad_id, PDO::PARAM_STR);
    $stmt7->execute();
    $result = $stmt7->fetch(PDO::FETCH_ASSOC);

    $sql20 = "SELECT EXISTS (SELECT 1 FROM advertisement WHERE ad_id = ? AND category = 'Auction') AS record_exist;";
    $stmt3 = $con->prepare($sql20);
    $stmt3->bindParam(1, $ad_id, PDO::PARAM_STR);
    $stmt3->execute();
    $result1 = $stmt3->fetch(PDO::FETCH_ASSOC);
   
} catch (PDOException $ex) {
    die("error is executing queries".$ex->getMessage());
}

if($result['record_exists'] || $result1['record_exist']){
    ?>
    <?php 
    
    if($_SESSION['status'] != 1){
        header("Location: login.php");
    }  
    

    //$Ad_ID=2;
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Advertisement Details</title>
        <link rel="icon" href="./images/logo.png" type="image/png">
        <link rel="stylesheet" href="./css/ViewBidstyle.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src ="./bid/bid.js"></script>
        <style>
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
            
        }
        #form table tr td{
            padding: 10px;
        }
        #bidAmount{
            border-radius: 10px;
            display: flex;
            align-items: center;
            text-align: center;
            height: 2.5em; 
            padding: 0 1em;
        }
        input::placeholder {
            text-align: center;
        }

    </style>
    
    <!---------------------------------for map----------------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
    </head>
    <body>
        <!--header-->
        <?php include './include/header.php'; 
require_once './classes/BidAds.php';

        $bid = new BidAdds('', '', 0, 0, 0, 0, 0, '', '', 0, '', '', '', 0, '',0,0, null, null, null, null, null, null);
        $adbid = $bid->getAdDetails($ad_id);
       



        ?>
        <div id="behind_swiper">
        <div class="grid-container">
            <!--Swiper gallery-->
            <div class="swiper mySwiper">
                <h2 class="title-bid"><?php echo htmlspecialchars($adbid['title']); ?></h2>
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
            
            <!--Bid area-->
            <div class="bid-area">
                <div class="bid-center">
                    <p>Auction Ends: <span><?php echo htmlspecialchars($adbid['end_time']); ?></span></p>
                    <div class="count-time">
                        <div class="dayss"><p>Days </p><span class="day"></span></div>
                        <div class="dayss"><p>hours  </p><span class="hour"></span></div>
                        <div class="dayss"><p>Minutes </p><span class="minute"></span></div>
                        <div class="dayss"><p>Seconds  </p><span class="second"></span></div>
                    </div>
                    <hr>
                    <div class="current-bid">
                        <table>
                            <tr><td>Bid Starting Price: <b>Rs <span id="min_auc_price"></span></b></td></tr>
                            <tr><td>Current Bid: <b>Rs <span id="current-bid"></span></b></td></tr>
                            <tr><td>Number of bids: <b><span id="number_of_bids"></span></b></td></tr>
                        </table>
                        <div class="place-bid">
                            <input type="text" name="bidAmount" id="bidAmount" placeholder="22,000">
                            <button class="place-bid-btn" id="place-bid" name="placeBid">Place Bid</button>
                        </div>
                        <input type="hidden" id="session-ad" value="<?php echo $adbid['ad_id']; ?>">
                        <input type="hidden" id="session-nic" value="<?php echo $nic; ?>">
                        <input type="hidden" id="session-email" value="<?php echo $email ?>">
                    </div>
                </div>


            </div>
        </div>
        </div>

        <!-- Auction information -->
        <div class="auction-information">

            <?php
            if($adbid){
                ?>
                    <div class='front-title'>
                        <div class='flex-fill'>Auction Information</div>
                    </div>
                    <hr>
                    <div class='info'>
                        <div class='tables1'>
                            <table>
                                <tr><td>Ad Reference Number</td><td><?php echo htmlspecialchars($adbid['ad_id']); ?></td></tr>
                                <tr><td>Ad title</td><td><?php echo htmlspecialchars($adbid['title']); ?></td></tr>
                                <tr><td>Category</td><td><?php echo htmlspecialchars($adbid['category']); ?></td></tr>
                                <tr><td>Type</td><td><?php echo htmlspecialchars($adbid['type']); ?></td></tr>
                                <tr><td>Description</td><td><?php echo isset($adbid['description']) ? htmlspecialchars($adbid['description']) : ''; ?></td></tr>
                                <tr><td>District</td><td><?php echo htmlspecialchars($adbid['district']); ?></td></tr>
                                <tr><td>Town</td><td><?php echo htmlspecialchars($adbid['town']); ?></td></tr>
                                <tr><td>Land Area</td><td><?php echo htmlspecialchars($adbid['land_Area']); ?></td></tr>
                                <?php echo isset($adbid['no_of_bedrooms']) ? "<tr><td>No of bedrooms</td><td>".$adbid['no_of_bedrooms']."</td></tr>" : '' ; ?>
                                <?php echo isset($adbid['no_of_bathrooms']) ? "<tr><td>No of bathrooms</td><td>".$adbid['no_of_bathrooms']."</td></tr>": ''; ?>
                            </table>
                        </div>
                        <div class='tables2'>
                            <table>
                                <?php echo isset($adbid['no_of_floors']) ? "<tr><td>No of floors</td><td>".$adbid['no_of_floors']."</td></tr>" : ''; ?>
                                <?php echo isset($adbid['floor_area']) ? "<tr><td>Floor area</td><td>".$adbid['floor_area']."</td></tr>" : '';  ?>
                                <tr><td>Bidding time period</td><td><?php echo isset($adbid['end_time']) ? htmlspecialchars($adbid['end_time']) : ''; ?></td></tr>
                                <tr><td>Min Auction Price</td><td>RS <?php echo isset($adbid['min_auc_price']) ? htmlspecialchars($adbid['min_auc_price']) : ''; ?></td></tr>
                                <tr><td>Current bid</td><td>Rs <?php echo isset($adbid['current_bid']) ? htmlspecialchars($adbid['current_bid']) : ''; ?></td></tr>
                                <tr><td>No of Bids</td><td><?php echo isset($adbid['number_of_bids']) ? htmlspecialchars($adbid['number_of_bids']) : '0'; ?></td></tr>
                                <tr><td><a href='./terms_conditions.php' target='_blank' id='terms-and-conditions'>View Terms and Conditions</a></td></tr>
                                
                            </table>
                         </div>
                    </div>
                <?php 
                } else { 
                    echo "<p>No auction information found.</p>";
                } 

            ?>
        </div>

        <!-- Footer -->
        <?php 
        include './addMap_adRedirector.php';
        include './include/footer.php'; ?>


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
    </body>
    </html>

    
    <?php
}
else{
    ?>
    
    <?php 
    
    //if($_SESSION['status'] != 1){
    //    header("Location: login.php");
    //}
    //require_once './classes/dbConnector.php';
    //$Ad_ID=3;
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Advertisement Details</title>
        <link rel="icon" href="./images/logo.png" type="image/png">
        <link rel="stylesheet" href="./css/View_fixed_addstyle.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">    
    <style>
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
            
        }
        #form table tr td{
            padding: 10px;
        }
    </style>
    
    <!---------------------------------for map----------------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    
   

    </head>
    <body>

           <!--header-->
           <?php
             include_once './include/header.php';

                

             $sql = 'SELECT 
                        a.*, 
                        t.town AS town, 
                        t.district AS district, 
                        u.name AS name, 
                        u.email AS email, 
                        u.contact_No AS originalContact,
                        i.image1 as image1, 
                        i.image2 as image2, 
                        i.image3 as image3, 
                        i.image4 as image4, 
                        i.image5 as image5
                    FROM 
                        advertisement a
                    JOIN 
                        town t ON a.town_id = t.town_id
                    JOIN 
                        registered_user u ON a.nic = u.nic
                    LEFT JOIN 
                        images i ON a.ad_id = i.ad_id
                    WHERE a.ad_id = :Ad_ID;';

             try {
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':Ad_ID', $ad_id, PDO::PARAM_STR);
                $stmt->execute();
                $adNonBid = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (Exception $ex) {
                    echo "Error: " . $ex->getMessage();
                }


           ?>



          <div class="swiper mySwiper">
                <h2 class="title-ad"><?php echo htmlspecialchars($adNonBid['title']); ?></h2>
                 <div class="swiper-wrapper">
                     <?php 
                          if(!empty($adNonBid['image1'])){?>
                    <div class="swiper-slide">
                        <?php 
                          if(!empty($adNonBid['image1'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adNonBid['image1']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adNonBid['image1']); ?>" alt='Image1' class="doc">
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
                          if(!empty($adNonBid['image2'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adNonBid['image2'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adNonBid['image2']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adNonBid['image2']); ?>" alt='Image2' class="doc">
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
                          if(!empty($adNonBid['image3'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adNonBid['image3'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adNonBid['image3']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adNonBid['image3']); ?>" alt='Image3' class="doc">
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
                          if(!empty($adNonBid['image4'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adNonBid['image4'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adNonBid['image4']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adNonBid['image4']); ?>" alt='Image4' class="doc">
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
                          if(!empty($adNonBid['image5'])){?>
                      <div class="swiper-slide">
                          <?php 
                          if(!empty($adNonBid['image5'])){
                              $finfo = new finfo(FILEINFO_MIME_TYPE);
                              $mimeType = $finfo->buffer($adNonBid['image5']);
                              ?>
                               <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($adNonBid['image5']); ?>" alt='Image5' class="doc">
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







         <!-- Add Information -->
         <?php
          include './addMap_adRedirector.php';
         ?>
        <div class="add-information">
            <?php
            if($adNonBid){
                ?>
                    <div class='front-title'>
                        <div class='flex-fill'>Advertisement Information</div>
                    </div>
                    <hr>
                    <div class='info'>
                        <div class='tables1'>
                            <table>
                                <tr><td>Ad Reference Number</td><td><?php echo htmlspecialchars($adNonBid['ad_id']); ?></td></tr>
                                <tr><td>Ad title</td><td><?php echo htmlspecialchars($adNonBid['title']); ?></td></tr>
                                <tr><td>Category</td><td><?php echo htmlspecialchars($adNonBid['category']); ?></td></tr>
                                <tr><td>Type</td><td><?php echo htmlspecialchars($adNonBid['type']); ?></td></tr>
                                <tr><td>Price</td><td>Rs <?php echo htmlspecialchars($adNonBid['price']); ?></td></tr>
                                <tr><td>Description</td><td><?php echo isset($adNonBid['description']) ? htmlspecialchars($adNonBid['description']) : ''; ?></td></tr>
                                <tr><td>District</td><td><?php echo htmlspecialchars($adNonBid['district']); ?></td></tr>

                                <tr><td>Land Area</td><td><?php echo htmlspecialchars($adNonBid['land_Area']); ?></td></tr>
                                <?php echo isset($adNonBid['no_of_bedrooms']) ? "<tr><td>No of bedrooms</td><td>".$adNonBid['no_of_bedrooms']."</td></tr>" : '' ; ?>
                                <?php echo isset($adNonBid['no_of_bathrooms']) ? "<tr><td>No of bathrooms</td><td>".$adNonBid['no_of_bathrooms']."</td></tr>": ''; ?>
                            </table>
                        </div>
                        <div class='tables2'>
                            <table>
                                <tr><td>Town</td><td><?php echo htmlspecialchars($adNonBid['town']); ?></td></tr>
                                <tr><td>Contact No</td><td><?php echo htmlspecialchars($adNonBid['contact_No']); ?></td></tr>
                                <?php echo isset($adNonBid['no_of_floors']) ? "<tr><td>No of floors</td><td>".$adNonBid['no_of_floors']."</td></tr>" : ''; ?>
                                <?php echo isset($adNonBid['floor_area']) ? "<tr><td>Floor area</td><td>".$adNonBid['floor_area']."</td></tr>" : '';  ?>
                                <tr><td>Name</td><td><?php echo htmlspecialchars($adNonBid['name']); ?></td></tr>
                                
                                <tr><td>Email</td><td><?php echo htmlspecialchars($adNonBid['email']); ?></td></tr>

                                <tr><td><a href='./terms_conditions.php' target='_blank' id='terms-and-conditions'>View Terms and Conditions</a></td></tr>
                                
                            </table>
                         </div>
                    </div>
                <?php 
                } else { 
                    echo "<p>No auction information found.</p>";
                } 

            ?>
        </div>

        <!-- Footer -->
        <?php include './include/footer.php'; ?>


    </body>
    </html>
    
    <?php
}

?>


<?php
session_start();
if (isset($_COOKIE['useremail']) && isset($_COOKIE['password'])) {
    include './include/cookie_logger.php';
}

if ($_SESSION['status'] != 1) {
    header("Location: login.php");
}
// include_once './classes/dbConnector.php';

$Ad_ID = 2;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bid</title>
        <link rel="icon" href="./images/logo.png" type="image/png">
        <link rel="stylesheet" href="./css/ViewBidstyle.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <script src ="./bid/bid.js"></script>

    </head>
    <body>
        <!--header-->

        <?php
        include './include/header.php';
        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();


        $sql = 'SELECT 
                a.*, 
                t.town AS town, 
                t.district AS district, 
                u.name AS name, 
                u.email AS email, 
                u.contact_No AS originalContact,
                b.end_time AS end_time, 
                b.min_auc_price AS min_auc_price,
                b.current_bid AS current_bid,
                b.number_of_bids AS number_of_bids,
                bi.nic AS current_bidder_nic,
                bi.current_bidder_email AS current_bidder_email,
                i.image1 as image1, 
                i.image2 as image2, 
                i.image3 as image3, 
                i.image4 as image4, 
                i.image5 as image5,
                b.verify_doc as verify_doc
            FROM 
                advertisement a
            JOIN 
                bids b ON a.ad_id = b.ad_id
            JOIN 
                bidder bi ON b.ad_id = bi.ad_id
            JOIN 
                town t ON a.town_id = t.town_id
            JOIN 
                registered_user u ON a.nic = u.nic
            LEFT JOIN 
                images i ON a.ad_id = i.ad_id
            WHERE a.ad_id = :Ad_ID;';

        try {
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':Ad_ID', $Ad_ID, PDO::PARAM_STR);
            $stmt->execute();
            $adbid = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo "Error: " . $ex->getMessage();
        }
        ?>

        <div class="grid-container">
            <!--Swiper gallery-->
            <div class="swiper mySwiper">
                <h2 class="title-bid"><?php echo htmlspecialchars($adbid['title']); ?></h2>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
<?php
if (!empty($adbid['image1'])) {
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
                    <div class="swiper-slide">
                        <?php
                        if (!empty($adbid['image2'])) {
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
                    <div class="swiper-slide">
                        <?php
                        if (!empty($adbid['image3'])) {
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
                    <div class="swiper-slide">
                        <?php
                        if (!empty($adbid['image4'])) {
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
                    <div class="swiper-slide">
                        <?php
                        if (!empty($adbid['image5'])) {
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
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>

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
                        <input type="hidden" id="session-nic" value="201234567897">
                        <input type="hidden" id="session-email" value="bobjohnson@example.com">
                    </div>
                </div>


            </div>
        </div>

        <!-- Auction information -->
        <div class="auction-information">

<?php
if ($adbid) {
    ?>
                <div class='front-title'>
                    <div class='flex-fill'>Auction Information</div>
                </div>
                <hr>
                <div class='info'>
                    <div class='tables1'>
                        <table>
                            <tr><td>Ad_ID Number</td><td><?php echo htmlspecialchars($adbid['ad_id']); ?></td></tr>
                            <tr><td>Ad title</td><td><?php echo htmlspecialchars($adbid['title']); ?></td></tr>
                            <tr><td>Category</td><td><?php echo htmlspecialchars($adbid['category']); ?></td></tr>
                            <tr><td>Type</td><td><?php echo htmlspecialchars($adbid['type']); ?></td></tr>
                            <tr><td>Price</td><td>Rs <?php echo htmlspecialchars($adbid['price']); ?></td></tr>
                            <tr><td>Description</td><td><?php echo isset($adbid['description']) ? htmlspecialchars($adbid['description']) : ''; ?></td></tr>
                            <tr><td>District</td><td><?php echo htmlspecialchars($adbid['district']); ?></td></tr>
                            <tr><td>Town</td><td><?php echo htmlspecialchars($adbid['town']); ?></td></tr>
                            <tr><td>Contact No</td><td><?php echo htmlspecialchars($adbid['contact_No']); ?></td></tr>
                            <tr><td>Land Area</td><td><?php echo htmlspecialchars($adbid['land_Area']); ?></td></tr>
    <?php echo isset($adbid['no_of_bedrooms']) ? "<tr><td>No of bedrooms</td><td>" . $adbid['no_of_bedrooms'] . "</td></tr>" : ''; ?>
    <?php echo isset($adbid['no_of_bathrooms']) ? "<tr><td>No of bathrooms</td><td>" . $adbid['no_of_bathrooms'] . "</td></tr>" : ''; ?>
                        </table>
                    </div>
                    <div class='tables2'>
                        <table>
    <?php echo isset($adbid['no_of_floors']) ? "<tr><td>No of floors</td><td>" . $adbid['no_of_floors'] . "</td></tr>" : ''; ?>
    <?php echo isset($adbid['floor_area']) ? "<tr><td>Floor area</td><td>" . $adbid['floor_area'] . "</td></tr>" : ''; ?>
                            <tr><td>Name</td><td><?php echo htmlspecialchars($adbid['name']); ?></td></tr>
                            <tr><td>NIC</td><td><?php echo htmlspecialchars($adbid['nic']); ?></td></tr>
                            <tr><td>Email</td><td><?php echo htmlspecialchars($adbid['email']); ?></td></tr>
                            <tr><td>Bidding time period</td><td><?php echo isset($adbid['end_time']) ? htmlspecialchars($adbid['end_time']) : ''; ?></td></tr>
                            <tr><td>Min Auction Price</td><td>RS <?php echo isset($adbid['min_auc_price']) ? htmlspecialchars($adbid['min_auc_price']) : ''; ?></td></tr>
                            <tr><td>Current bid</td><td>Rs <?php echo isset($adbid['current_bid']) ? htmlspecialchars($adbid['current_bid']) : ''; ?></td></tr>
                            <tr><td>No of Bids</td><td><?php echo isset($adbid['number_of_bids']) ? htmlspecialchars($adbid['number_of_bids']) : '0'; ?></td></tr>
                            <tr><td><a href='#' target='_blank' id='terms-and-conditions'>View Terms and Conditions</a></td></tr>
                            <tr><td><a href='#' id='other-listings'>View Seller's Other Listings</a></td></tr>
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
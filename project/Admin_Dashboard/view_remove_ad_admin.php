<?php
session_start();
if(isset($_GET['Ad_ID']) && isset($_GET['rowNumber'])){
    $Ad_ID = htmlspecialchars($_GET['Ad_ID']);
    $rowNumber = $_GET['rowNumber'];
} else {
    echo '<h3 style="color:red">No Ad ID Provided!</h3>';
    exit();
}

require_once '../classes/Admin.php';

if (isset($_SESSION['useremail'])) {
    $admin = new Admin($_SESSION['useremail']);
    $result = $admin->bidCheck($Ad_ID);
}


if($result['record_exists']){

        require_once '../classes/Admin.php';

        if (isset($_SESSION['useremail'])) {
            $admin = new Admin($_SESSION['useremail']);
            $user = $admin->bidCehckedView($Ad_ID);
        }
                

        if($user){
            ?>
            <div class="user-details-container">
                <h2>- Details of the Bidding Advertisement -</h2>
                <table class="user-details">
                        <tr>
                            <td><b>1) Ad Number : </b></td>
                            <td><?php echo htmlspecialchars($user['ad_id']); ?></td>
                            <td colspan="2"><b>21) Verification Document : </b></td>
                        </tr>
                        <tr>
                            <td><b>2) Ad Title : </b></td>
                            <td><?php echo htmlspecialchars($user['title']); ?></td>
                            <td rowspan="6" colspan="2">
                                <div class="user-verification">
                                    <?php 
                                    if(!empty($user['verify_doc'])){
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($user['verify_doc']);
                                        ?>
                                         <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['verify_doc']); ?>" alt='verify_doc' class="doc">
                                        <?php

                                    } else {
                                        ?>
                                        <p>No Verification Document Available</p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td><b>3) Category : </b></td>
                            <td><?php echo htmlspecialchars($user['category']); ?></td>
                        </tr>
                        <tr>
                            <td><b>4) Type : </b></td>
                            <td><?php echo htmlspecialchars($user['type']); ?></td>
                        </tr>
                        <tr>
                            <td><b>5) Price : </b></td>
                            <td>Rs <?php echo htmlspecialchars($user['price']); ?></td>
                        </tr>
                        <tr>
                            <td><b>6) Description : </b></td>
                            <td><?php echo isset($user['description']) ? htmlspecialchars($user['description']) : ''; ?></td>
                        </tr>

                        <tr>
                            <td><b>7) District : </b></td>
                            <td><?php echo htmlspecialchars($user['district']); ?></td>

                        </tr>
                        <tr>
                            <td><b>8) Town : </b></td>
                            <td><?php echo htmlspecialchars($user['town']); ?></td>
                            <td colspan="2"><b>22) Images : </b></td>

                        </tr>
                        <tr>
                            <td><b>9) Contact No : </b></td>
                            <td><?php echo htmlspecialchars($user['contact_No']); ?></td>
                            <td rowspan="6" colspan="2">
                                <div class="user-verification">
                                   <div class="swiper mySwiper">
                                        <div class="swiper-wrapper">
                                          <div class="swiper-slide">
                                              <?php 
                                                if(!empty($user['image1'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image1']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image1']); ?>" alt='Image1' class="doc">
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
                                                if(!empty($user['image2'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image2']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image2']); ?>" alt='Image2' class="doc">
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
                                                if(!empty($user['image3'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image3']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image3']); ?>" alt='Image3' class="doc">
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
                                                if(!empty($user['image4'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image4']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image4']); ?>" alt='Image4' class="doc">
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
                                                if(!empty($user['image5'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image5']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image5']); ?>" alt='Image5' class="doc">
                                                    <?php

                                                } else {
                                                    ?>
                                                    <p>No image5 Available</p>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-pagination"></div>
                                      </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>10) Land Area : </b></td>
                            <td><?php echo htmlspecialchars($user['land_Area']); ?></td>

                        </tr>
                        <tr>
                            <td><b>11) No of bedrooms : </b></td>
                            <td><?php echo isset($user['no_of_bedrooms']) ? htmlspecialchars($user['no_of_bedrooms']) : ''; ?></td>

                        </tr>
                        <tr>
                            <td><b>12) No of bathrooms : </b></td>
                            <td><?php echo isset($user['no_of_bathrooms']) ? htmlspecialchars($user['no_of_bathrooms']) : ''; ?></td>

                        </tr>
                        <tr>
                            <td><b>13) No of floors : </b></td>
                            <td><?php echo isset($user['no_of_floors']) ? htmlspecialchars($user['no_of_floors']) : ''; ?></td>

                        </tr>
                        <tr>
                            <td><b>14) Floor area : </b></td>
                            <td><?php echo isset($user['floor_area']) ? htmlspecialchars($user['floor_area']) : ''; ?></td>

                        </tr>
                        <tr>
                            <td><b>15) Name : </b></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><b>23) Current Bid : </b></td>
                            <td><?php echo isset($user['current_bid']) ? htmlspecialchars($user['current_bid']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>16) NIC : </b></td>
                            <td><?php echo htmlspecialchars($user['nic']); ?></td>
                            <td><b>24) No of bids : </b></td>
                            <td><?php echo isset($user['number_of_bids']) ? htmlspecialchars($user['number_of_bids']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>17) Email : </b></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><b>25) NIC of current bidder : </b></td>
                            <td><?php echo isset($user['current_bidder_nic']) ? htmlspecialchars($user['current_bidder_nic']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>18) Contact No from User : </b></td>
                            <td><?php echo htmlspecialchars($user['originalContact']); ?></td>
                            <td><b>26) Email of current bidder : </b></td>
                            <td><?php echo isset($user['current_bidder_email']) ? htmlspecialchars($user['current_bidder_email']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>19) Bidding time period : </b></td>
                            <td><?php echo isset($user['end_time']) ? htmlspecialchars($user['end_time']) : ''; ?></td>
                            <td><b>27) Longitude : </b></td>
                            <td><?php echo isset($user['longitude']) ? htmlspecialchars($user['longitude']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>20) Min Auction Price : </b></td>
                            <td><?php echo isset($user['min_auc_price']) ? htmlspecialchars($user['min_auc_price']) : ''; ?></td>
                            <td><b>28) Latitude : </b></td>
                            <td><?php echo isset($user['latitude']) ? htmlspecialchars($user['latitude']) : ''; ?></td>
                        </tr>
                </table>

                <div class="button-group">
                    <button class="close-btn">Close</button>
                    <button class="btn btn-sm btn-primary UD" id="removeAdBtn" onclick="popupRemoveAd(<?php echo $rowNumber ?>)">Remove Ad</button>
                </div>
            </div>
            <?php    
        } else {
            echo '<h3 style="color:red">Advertisement not found!</h3>';
            echo '</br><button class="close-btn">Close</button>';
        }
        
    }
    
    else{
        require_once '../classes/Admin.php';

        if (isset($_SESSION['useremail'])) {
            $admin = new Admin($_SESSION['useremail']);
            $user = $admin->nonbidCheckedView($Ad_ID);
            
        }

        if($user){
            ?>
            <div class="user-details-container">
                <h2>- Details of the Non-Bid Advertisement -</h2>
                <table class="user-details">
                        <tr>
                            <td><b>1) Ad_ID Number : </b></td>
                            <td><?php echo htmlspecialchars($user['ad_id']); ?></td>
                            <td colspan="2"><b>22) Images : </b></td>
                        </tr>
                        <tr>
                            <td><b>2) Ad Title : </b></td>
                            <td><?php echo htmlspecialchars($user['title']); ?></td>
                            <td rowspan="6" colspan="2">
                                <div class="user-verification">
                                   <div class="swiper mySwiper">
                                        <div class="swiper-wrapper">
                                          <div class="swiper-slide">
                                              <?php 
                                                if(!empty($user['image1'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image1']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image1']); ?>" alt='Image1' class="doc">
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
                                                if(!empty($user['image2'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image2']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image2']); ?>" alt='Image2' class="doc">
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
                                                if(!empty($user['image3'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image3']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image3']); ?>" alt='Image3' class="doc">
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
                                                if(!empty($user['image4'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image4']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image4']); ?>" alt='Image4' class="doc">
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
                                                if(!empty($user['image5'])){
                                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                                    $mimeType = $finfo->buffer($user['image5']);
                                                    ?>
                                                     <img src="data:<?php echo $mimeType; ?>;base64,<?php echo base64_encode($user['image5']); ?>" alt='Image5' class="doc">
                                                    <?php

                                                } else {
                                                    ?>
                                                    <p>No image5 Available</p>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-pagination"></div>
                                      </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>3) Category : </b></td>
                            <td><?php echo htmlspecialchars($user['category']); ?></td>
                        </tr>
                        <tr>
                            <td><b>4) Type : </b></td>
                            <td><?php echo htmlspecialchars($user['type']); ?></td>
                        </tr>
                        <tr>
                            <td><b>5) Price : </b></td>
                            <td>Rs <?php echo htmlspecialchars($user['price']); ?></td>
                        </tr>
                        <tr>
                            <td><b>6) Description : </b></td>
                            <td><?php echo isset($user['description']) ? htmlspecialchars($user['description']) : ''; ?></td>
                        </tr>

                        <tr>
                            <td><b>7) District : </b></td>
                            <td><?php echo htmlspecialchars($user['district']); ?></td>


                        </tr>
                        <tr>
                            <td><b>8) Town : </b></td>
                            <td><?php echo htmlspecialchars($user['town']); ?></td>
                            <td><b>15) Name : </b></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>

                        </tr>
                        <tr>
                            <td><b>9) Contact No : </b></td>
                            <td><?php echo htmlspecialchars($user['contact_No']); ?></td>
                            <td><b>16) NIC : </b></td>
                            <td><?php echo htmlspecialchars($user['nic']); ?></td>
                        </tr>
                        <tr>
                            <td><b>10) Land Area : </b></td>
                            <td><?php echo htmlspecialchars($user['land_Area']); ?></td>
                            <td><b>17) Email : </b></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                        </tr>
                        <tr>
                            <td><b>11) No of bedrooms : </b></td>
                            <td><?php echo isset($user['no_of_bedrooms']) ? htmlspecialchars($user['no_of_bedrooms']) : ''; ?></td>
                            <td><b>18) Contact No from User : </b></td>
                            <td><?php echo htmlspecialchars($user['originalContact']); ?></td>
                        </tr>
                        <tr>
                            <td><b>12) No of bathrooms : </b></td>
                            <td><?php echo isset($user['no_of_bathrooms']) ? htmlspecialchars($user['no_of_bathrooms']) : ''; ?></td>
                            <td><b>19) Longitude : </b></td>
                            <td><?php echo isset($user['longitude']) ? htmlspecialchars($user['longitude']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>13) No of floors : </b></td>
                            <td><?php echo isset($user['no_of_floors']) ? htmlspecialchars($user['no_of_floors']) : ''; ?></td>
                            <td><b>20) Latitude : </b></td>
                            <td><?php echo isset($user['latitude']) ? htmlspecialchars($user['latitude']) : ''; ?></td>
                        </tr>
                        <tr>
                            <td><b>14) Floor area : </b></td>
                            <td><?php echo isset($user['floor_area']) ? htmlspecialchars($user['floor_area']) : ''; ?></td>

                        </tr>
                </table>

                <div class="button-group">
                    <button class="close-btn">Close</button>
                    <button class="btn btn-sm btn-primary UD" id="removeAdBtn" onclick="popupRemoveAd(<?php echo $rowNumber ?>)">Remove Ad</button>
                </div>
            </div>
            <?php    
        } else {
            echo '<h3 style="color:red">Advertisement not found!</h3>';
            echo '</br><button class="close-btn">Close</button>';
        }
            }
?>
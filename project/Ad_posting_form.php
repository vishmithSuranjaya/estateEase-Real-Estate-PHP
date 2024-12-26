<?php
session_start();
if(isset($_COOKIE['useremail']) && isset($_COOKIE['password'])){
        include './include/cookie_logger.php';
    }
if($_SESSION['status'] != 1){
    header("Location: login.php");
}
include_once './classes/dbConnector.php';
include_once './include/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>estateEase | Post an Advertisement</title>
    <link rel="icon" href="./images/logo.png" type="image/png">
    <link rel="stylesheet" href="./CSS/ad_form_styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyA-AB-9XZd-iQby-bNLYPFyb0pR2Qw3orw"></script>

  <style>
      .btn-update {
        background-color: rgb(0,158,96);
        border:1px solid rgb(0,158,96);
        border-radius:4px;
        color: white;
        padding:10px;
}
     .btn-update:hover{
        background-color: #ebebeb;
        color:rgb(0,158,96);
     }
       /* styles for the map. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #map {
        height: 75%;
        width:86%;
        margin:auto;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
<body style="background:var(--background-color);">
    <!--------------------------------------including google map------->
<div id="map"></div>
<script src="mapscript.js"></script> 

    <section class="container">
        <form action="ad_posting_inc.php" method="POST"  enctype="multipart/form-data">
            <?php
               if (isset($_GET["status"])) {
                if ($_GET["status"] == 1) {
                    echo "<script>alert('Enter Valid Price!')</script>";
                }elseif($_GET["status"]==2){
                    echo "<script>alert('Enter Valid Minimum price!')</script>";
                }elseif ($_GET["status"] == 3) {
                    echo "<script>alert('Enter Valid Description!')</script>";
                } elseif ($_GET["status"] == 4) {
                    echo "<script>alert('Please enter a valid title!')</script>";
                } elseif ($_GET["status"] == 5) {
                    echo "<script>alert('Please enter valid Numbers')</script>";
                } elseif ($_GET["status"] == 6) {
                    echo "<script>alert('Please enter  valid Numbers')</script>";
                } elseif ($_GET["status"] == 7) {
                    echo "<script>alert('Please enter  valid Numbers')</script>";
                } elseif ($_GET["status"] == 8) {
                    echo "<script>alert('PLease enter valid  Area! ')</script>";
                } elseif ($_GET["status"] == 9) {
                    echo "<script>alert('PLease enter valid floor area! ')</script>";
                } elseif ($_GET["status"] == 10) {
                    echo "<script>alert('PLease enter valid contact number! ')</script>";
                } elseif ($_GET["status"] == 11) {
                    echo "<script>alert('Advertisement submitted to admin approval!')</script>";
                } elseif ($_GET["status"] == 12) {
                     echo "<script>alert('Advertisement posted succesfully!')</script>";
                }elseif($_GET["status"]==13){
                      echo "<script>alert('Please fill all fields!')</script>";
                }elseif($_GET["status"]==14){
                    echo "<script>alert('Please Enter a valid verification document!')</script>";
                }elseif($_GET["status"]==15){
                    echo "<script>alert('Please Enter valid images!')</script>";
                }
            }

            ?>
            <h2>estateEase</h2>
            <hr>

            <div class="category"> 
                <h4>Category</h4>
                <input type="radio" name="category" id="category1" value="Fixed" onchange="showDetails()">
                <label for="">Fixed Price</label>

                <input type="radio" name="category" id="category2" value="Auction" onchange="showDetails()">
                <label for="">Auction</label>

                <input type="radio" name="category" id="category3" value="Rent" onchange="showDetails()">
                <label for="">Rent</label>
                <hr>
            </div>

            <div class="type">
                <h4>Type</h4>
                <input type="radio" name="type" id="" value="Land">
                <label for="">Land</label>

                <input type="radio" name="type" id="" value="Apartment">
                <label for="">Apartment</label>

                <input type="radio" name="type" id="" value="House">
                <label for="">House</label>

                <input type="radio" name="type" id="" value="Commercial Properties">
                <label for="">Commercial Properties</label><br><br>
                <hr>
            </div>

            <div class="aditional-details-on-type">
                
                            <label for="">No. of Rooms</label>
                            <input type="text" name="no_rooms" id="" ><br><br>
                        
                            <label for="">No. of Bathrooms</label>
                            <input type="text" name="no_bath" id="" ><br><br>
                        
                            <label for="">No. of floors</label>
                            <input type="text" name="no_floors" id="" ><br><br>
                        
                            <label for="">Floor area</label>
                            <input type="text" name="floorArea" id="" > sq.ft<br><br>
                       
                
            </div>

            <div >
            
                <label for="">Land Size</label>
                    <input type="text" name="area" id="" class="form-control">
                    <select name="area_unit" id="">
                        <option value="perches">PERCHES</option>
                        <option value="acres">ACRES</option>
                        <option value="sqft">sq ft</option>
                    </select><br><br>
                  
                    <label for="">Title</label>
                    <input type="text" name="title" id="title_input" class="form-control"><br>
                
                    <label for="">Description</label>
                    <input type="text" name="description" id="desc_input" contenteditable="true" class="form-control"><br>
                
                    <label for="">Price</label>
                    <input type="text" name="price" id="price_input" class="form-control"><br>
                
                    <div class="form_feild">   
                 
                 <label for="district">District:</label><br>
                 
                 <?php
                    $dbcon = new DbConnector();
                    $con = $dbcon->getConnection();

                    $sql = 'SELECT DISTINCT district FROM town';
                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                    $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                 
                 <select class="form-control"  id="dropdown1" name="district" onchange="updateTowns()" required>
                        <option value="">Select District</option>
                        <?php foreach ($districts as $district): ?>
                            <option value="<?= htmlspecialchars($district['district']) ?>"><?= htmlspecialchars($district['district']) ?></option>
                        <?php endforeach; ?>
                    </select>
               </div>
                    </br>
               <div class="form_feild">   
                <!-- <input class="feild1" type="text" name="town" placeholder="Town*" required=""><br><br>-->
                 <label for="town">Town:</label>
                    <select class="form-control" name="town" id="a" required>
                       
                    </select>
               </div>
                
            
            </div>
            <hr>
            
            <div class="ad-images">
                <p>*Input up to 5 images, at least 1 image.</p>
                <input type="file" id="img01" name='img01'>
                <input type="file" id="img02" name='img02'>
                <input type="file" id="img03" name='img03'>
                <input type="file" id="img04" name='img04'>
                <input type="file" id="img05" name='img05'>
                <hr>
            </div>
            
            

            <div class="seller-details">
            
                <label for="">
                <?php
               if(isset($_SESSION['status'])){   //getting logged in user name from session variables
                echo "Name : ".$_SESSION['username'];
            }
            ?>
                </label><br>
                <label for="">Contact Number</label><br>
                <input type="text" name="contactNo" id=""><br><br>

                
            </div>
                      <!---additional details for the sell with bid option-->
            <div id="category2Details" class="additional-details">
             <label for="">Minimum auction price*</label><br>
             <input type="text" name="min_auc_price" id="" ><br><br>

             <label for="">BID Ending Date/Time*</label><br>
             <input type="date" name="date" id="" placeholder="Bid Ending Days">
             <input type="time" name="time" id="" placeholder="Bid Ending Time"><br><br>

             <label for="">Enter valid document of the property*</label><br>
            <input type="file" name="validDoc" id=""><br><br>
            </div>
                      
             <div id="map1">
                <label for=""><span style="color:red;">*Do not forgot to mark your location on above map</span></label>
                <input type="hidden" name="lattitude" id="lat">
                <input type="hidden" name="longitude" id="lng">
                
            </div>
            <div class="button-div" id="button-div" onclick="paymentGateway();" style="display:none;">Click here to Pay</div><br>
            <input type="submit" name="submit" id="submitBtn" value="Post Advertisement" class="btn-update" style="display:none;"><br><br>  <!-- submit the form-->
            
            
            <div id="category1Details" class="additional-details"> <!--additional details-->
            </div>

            <div id="category3Details" class="additional-details">   <!--additional details-->
            </div>
        </form>
       
    </section>
    <script>
         function showDetails() {   //dispalying additional details according to the user selection
          
        const category1Details = document.getElementById("category1Details");
        const category2Details = document.getElementById("category2Details");
        const category3Details = document.getElementById("category3Details");
        const selectedCategory = document.querySelector('input[name="category"]:checked').value;
        const submitBtn = document.getElementById("submitBtn");
        const payDiv = document.getElementById("button-div");
        
        // Hide all details first
        category1Details.style.display = "none";
        category2Details.style.display = "none";
        category3Details.style.display = "none";
        
        // Show details based on selected category
        if (selectedCategory === "Fixed") {
//            category1Details.style.display = "block";
//            submitBtn.value = "Post Advertisement";
//            payDiv.style.display = "none";
//            submitBtn.style.display = "inline-block";
            category1Details.style.display = "block";
            submitBtn.style.display = "none";
            submitBtn.value = "Post Advertisement";
            payDiv.style.display = "inline-block";
        } else if (selectedCategory === "Auction") {
            category2Details.style.display = "block";
            submitBtn.style.display = "none";
            submitBtn.value = "Send For Approval";
            payDiv.style.display = "inline-block";
        } else if (selectedCategory === "Rent") {
//            category3Details.style.display = "block";
//            submitBtn.value = "Post Advertisement";
//            payDiv.style.display = "none";
//            submitBtn.style.display = "inline-block";
            category1Details.style.display = "block";
            submitBtn.style.display = "none";
            submitBtn.value = "Post Advertisement";
            payDiv.style.display = "inline-block";
        }
        
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

    <?php
      include_once './include/footer.php';

      $_SESSION['payment_status'] = false;
    ?>
    <script src="script.js"></script>
    <script type="text/javascript" src="http://www.payhere.lk/lib/payhere.js"></script>
</body>
</html>